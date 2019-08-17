<div class="table-responsive">
    <table class="table table-bordered table-hover {{ $tableClasses ?? ''}}">
        <thead class="thead-light">
            {{ $headers ?? ''}}
        </thead>
        <tbody>
            {{ $slot ?? '' }}
        </tbody>
        <tfoot>
            {{ $footers ?? '' }}
        </tfoot>
    </table>
</div>