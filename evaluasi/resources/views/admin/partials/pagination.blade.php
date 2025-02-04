<div class="mt-4">
    {{ $questions->appends(['type' => request('type')])->links() }}
</div>
