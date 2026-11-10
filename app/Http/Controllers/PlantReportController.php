<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PlantReportController extends Controller
{
    // The four required report types
    private const TYPES = [
        'price_list'   => 'Plant Price List',
        'in_stock'     => 'In-Stock Plants',
        'out_of_stock' => 'Out-of-Stock Plants',
        'by_category'  => 'Plants by Category',
    ];

    /**
     * Build ONE query from the request filters.
     * The page, the PDF and the CSV all use this same method, so the
     * exports always match what is selected on screen.
     */
    private function buildQuery(Request $request)
    {
        $type = $request->input('type', 'price_list');
        $query = Plant::with('user');

        // The report type can force a stock status
        if ($type === 'in_stock') {
            $query->where('stock_status', 'in_stock');
        } elseif ($type === 'out_of_stock') {
            $query->where('stock_status', 'out_of_stock');
        } elseif ($request->filled('stock_status')) {
            // Otherwise, apply the optional stock status filter
            $query->where('stock_status', $request->stock_status);
        }

        // Optional category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Sorting depends on the report type
        if ($type === 'by_category') {
            $query->orderBy('category')->orderBy('name');
        } else {
            $query->orderBy('name');
        }

        return $query;
    }

    private function title(Request $request): string
    {
        return self::TYPES[$request->input('type', 'price_list')] ?? 'Plant Report';
    }

    // Report page with filters
    public function index(Request $request)
    {
        $plants = $this->buildQuery($request)->get();
        $title = $this->title($request);
        $types = self::TYPES;

        return view('reports.plants', compact('plants', 'title', 'types'));
    }

    // PDF export (uses the same filters as the page)
    public function pdf(Request $request)
    {
        $plants = $this->buildQuery($request)->get();
        $title = $this->title($request);

        return Pdf::loadView('reports.plants_pdf', compact('plants', 'title'))
            ->download('plant-report.pdf');
    }

    // CSV export (opens in Excel; uses the same filters as the page)
    public function csv(Request $request)
    {
        $plants = $this->buildQuery($request)->get();

        return response()->streamDownload(function () use ($plants) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Name', 'Category', 'Unit Price', 'Stock Status', 'Description', 'Created By']);

            foreach ($plants as $p) {
                fputcsv($out, [
                    $p->name,
                    ucfirst($p->category),
                    number_format($p->unit_price, 2, '.', ''),
                    $p->stock_label,
                    $p->description,
                    $p->user->name,
                ]);
            }
            fclose($out);
        }, 'plant-report.csv', ['Content-Type' => 'text/csv']);
    }
}