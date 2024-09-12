<div>
    <div class="container p-7">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-2xl">Dashboard - {{ $council->name }}</h1>
                <div class="flex mt-5 mb-7 p-3" id="stats">
                    <x-stat title="Beschlüsse" value="{{ $resolutions_count }}" icon="o-document-text" />
                    <x-stat title="Kategorien" value="{{ $categories_count }}" icon="o-tag" />
                    <x-stat title="Antragsteller*innen" value="{{ $applicants_count }}" icon="o-users" />
                    <x-stat title="Gremien" value="{{ $councils_count }}" icon="o-user-group" />
                </div>
                <div class="grid grid-cols-3 gap-x-3" id="latest-entries">
                    <div class="border-r-2 p-3">
                        <h3 class="text-xl">Neue Beschlüsse</h3>
                        @foreach ($latest_resolutions as $resolution)
                            <x-list-item :item="$resolution" value="title" sub-value="category.name"
                                link="admin/resolutions" no-separator />
                        @endforeach
                    </div>
                    <div class="border-r-2 p-3">
                        <h3 class="text-xl">Neue Kategorien</h3>
                        @foreach ($latest_categories as $category)
                            @php
                                $resolutionCount = $category->resolutions_count ?? 0;
                            @endphp
                            <x-list-item :item="$category" value="name" link="admin/categories" no-separator>
                                <x-slot:sub-value>
                                    {{ $resolutionCount }} {{ $resolutionCount === 1 ? 'Beschluss' : 'Beschlüsse' }}
                                </x-slot:sub-value>
                            </x-list-item>
                        @endforeach
                    </div>
                    <div class="p-3">
                        <h3 class="text-xl">Neue Antragsteller*innen</h3>
                        @foreach ($latest_applicants as $applicant)
                            @php
                                $resolutionCount = $applicant->resolutions_count ?? 0;
                            @endphp
                            <x-list-item :item="$applicant" value="name" link="admin/applicants" no-separator>
                                <x-slot:sub-value>
                                    {{ $resolutionCount }} {{ $resolutionCount === 1 ? 'Beschluss' : 'Beschlüsse' }}
                                </x-slot:sub-value>
                            </x-list-item>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
