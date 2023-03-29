<?php


namespace App\Http\Repositories;

use App\Http\Libraries\DataTable;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;

use function request;


class ArticleRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new Article());
    }

    public function getDataTable($columns)
    {
        DataTable::init(new Article(), $columns);
        $name = request('datatable.query.heading', '');

        if (!empty($name)) {
            DataTable::where('name', 'LIKE', '%' . addslashes($name) . '%');
        }

        $articles = DataTable::get();
        $dateFormat = config('settings.date-format');

        $start = 1;
        if ($articles['meta']['start'] > 0 && $articles['meta']['page'] > 1) {
            $start = $articles['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($articles['data']) > 0) {
            foreach ($articles['data'] as $key => $data) {
                $data['count'] = $count++;
                $data['name'] = $data['name']['en'];

                $data['content'] = Str::limit($data['content']['en'], 150, $end = '...');
                $data['actions'] = '<a href="' . route('admin.dashboard.articles.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.articles.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';

                $articles['data'][$key] = $data;
            }
        }
        return $articles;
    }


    public function all()
    {
        if ($this->getPaginate() == 0) {
            $articles = $this->getModel()->latest()->all();
        } else {
            $articles = $this->getModel()->latest()->paginate($this->getPaginate());
        }
        return $articles;
    }

    public function getViewParams($id = 0)
    {
        $article = new Article();
        if ($id > 0) {
            $article = $this->getModel()->findOrFail($id);
        }
        foreach (cache('LANGUAGES') as $lang) {

            if (is_null($article->name)) {
                $article->name = [];
                $article->name += [$lang['short_code'] => ''];
            } else {
                if (!array_key_exists($lang['short_code'], $article->name)) {

                    $article->name += [$lang['short_code'] => ''];
                }
            }
            if (is_null($article->content)) {
                $article->content = [];
                $article->content += [$lang['short_code'] => ''];
            } else {
                if (!array_key_exists($lang['short_code'], $article->content)) {

                    $article->content += [$lang['short_code'] => ''];
                }
            }
        }
        return $article;
    }

    public function get($slug)
    {
        $article = $this->getModel()->where('slug', $slug)->first();
        return $article;
    }

    public function save($request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->except('_token', '_method');
            $slug = Str::slug($data['name']['en']);
            $data['slug'] = $slug;

            $data = $this->getModel()->updateOrCreate(['id' => $id], $data);
            DB::commit();
            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function show()
    {
        dd("show");
    }

    public function destroy($id)
    {
        $article = $this->getModel()->where('id', '=', $id)->firstOrFail();
        //        deleteImage($article->getOriginal('image'));
        //        deleteImage($article->getOriginal('detail_image'));
        $article::destroy($id);
        return $article;
    }
}
