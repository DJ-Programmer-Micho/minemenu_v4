<div class="dropdown-menu">
    @foreach ($filteredLocales as $locale)
        <a class="dropdown-item" href="#" wire:click="switchLanguage('{{ $locale }}')">{{ strtoupper($locale) }}</a>
    @endforeach
</div>
