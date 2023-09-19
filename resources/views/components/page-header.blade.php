@props(['header' => '', 'sub_header' => ''])

<header>
    <h1 class="h4">{{ $header }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item text-muted active" aria-current="page">
                {{ $sub_header }}
            </li>
        </ol>
    </nav>
</header>