<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\Serie;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Livewire\Component;

class SearchBox extends Component
{
    public $term = "";

    public function render()
    {
        $items = $this->searchOnElasticsearch($this->term);
        return view('livewire.search-box', ['items' => $items, 'categories' => null]);
    }

    public function autocomplete(string $query = '')
    {
        $serie = new Serie();

        $client = \Elastic\Elasticsearch\ClientBuilder::create()->build();

        $test = $client->search([
            'index' => $serie->getSearchIndex(),
            'type' => $serie->getSearchType(),
            'body' => [
                'query' => [
                    'fuzzy' => [
                        'message' => $query,
                    ],
                ],
                'suggest' => [
                    'title-suggestion' => [
                        'text' => $query,
                        'term' => [
                            'field' => 'title'
                        ]
                    ]
                ]
            ]
        ]);

        $result = $test->asArray();

        ray($result);
    }

    private function searchOnElasticsearch(string $query = ''): ?array
    {
        $model = new Serie();

        $client = \Elastic\Elasticsearch\ClientBuilder::create()->build();

        $items = $client->search([
            'index' => $model->getTable(),
            'type' => $model->getTable(),
            'default_operator' => 'OR',
            'q' => '' . $query . '',
            'body' => [
                'query' => [
                    'combined_fields' => [
                        'query' => '*' . $query . '*',
                        'fields' => ['title', 'content'],
                        'operator' => 'or'
                    ],
                ],
                'size' => 8,
                'highlight' => [
                    'pre_tags' => ['<strong class="text-gray-900">'],
                    'post_tags' => ['</strong>'],
                    'fields' => [
                        'title' => ['type' => 'plain'],
                        'content' => ['type' => 'plain']
                    ],
                ]
            ],
        ]);

        $items = !empty($items['hits']['hits']) ? $items['hits']['hits'] : null;

        // Create overlay on top of regular application
        if($items) {
            $this->dispatchBrowserEvent('tableVisible', ['value' => true]);
            $this->dispatchBrowserEvent('searchItems', ['items' => $items]);
        } else {
            $this->dispatchBrowserEvent('tableVisible', ['value' => false]);
            $this->dispatchBrowserEvent('searchItems', ['items' => false]);
        }

        return $items;
    }

    public function close(): void
    {
        $this->term = "";
    }
}
