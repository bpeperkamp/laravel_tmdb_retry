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
        $model = new Serie();

        $client = \Elastic\Elasticsearch\ClientBuilder::create()->build();

        $test = $client->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
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

        // Create overlay on top of regular application
        if($query) {
            $this->dispatchBrowserEvent('showBackground', ['value' => true]);
        } else {
            $this->dispatchBrowserEvent('showBackground', ['value' => false]);
        }

        $items = !empty($items['hits']['hits']) ? $items['hits']['hits'] : null;

        return $items;
    }

    public function close(): void
    {
        $this->term = "";
    }
}
