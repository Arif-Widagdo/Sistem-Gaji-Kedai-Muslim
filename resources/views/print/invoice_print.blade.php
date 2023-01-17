<x-print-layout title="{{ __('Invoice Histories') }} | Print">
    <!-- title row -->
    @include('components.invoice.header_invoice')

    <!-- Table row -->
    @include('components.invoice.table_invoice')

</x-print-layout>