<div class="col-xl-3 col-sm-6 mb-3">
    <div class="card {{ $textColor ?? 'text-white'}} {{ $bgColor ?? 'bg-primary'}} o-hidden h-100">
        <div class="card-body">
            <div class="card-body-icon">
                <i class="fas fa-fw {{ $faIcon ?? 'fa-cog' }}"></i>
            </div>
            <div class="mr-5">{{ $slot }}</div>
        </div>
        <a class="card-footer {{ $textColor ?? 'text-white' }} clearfix small z-1" href="{{ $link ?? '#' }}">
            <span class="float-left">{{ $viewText ?? 'View Details' }}</span>
            <span class="float-right">
                <i class="fas fa-angle-right"></i>
            </span>
        </a>
    </div>
</div>