<?php


namespace App\Http\Repositories;

use App\Http\Libraries\DataTable;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;

use function request;


class FaqRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new Faq());
    }

    public function getDataTable($columns)
    {
        DataTable::init(new Faq(), $columns);
        $name = request('datatable.query.heading', '');

        if (!empty($name)) {
            DataTable::where('name', 'LIKE', '%' . addslashes($name) . '%');
        }

        $faqs = DataTable::get();
        $dateFormat = config('settings.date-format');

        $start = 1;
        if ($faqs['meta']['start'] > 0 && $faqs['meta']['page'] > 1) {
            $start = $faqs['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($faqs['data']) > 0) {
            foreach ($faqs['data'] as $key => $data) {
                $data['count'] = $count++;
                $data['name_en'] = $data['question']['en'];
                $data['name_ar'] = $data['question']['ar'];

                $data['actions'] = '<a href="' . route('admin.dashboard.faqs.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.faqs.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';

                $faqs['data'][$key] = $data;
            }
        }
        return $faqs;
    }


    public function all()
    {
        if ($this->getPaginate() == 0) {
            $faqs = $this->getModel()->latest()->get();
        } else {
            $faqs = $this->getModel()->latest()->paginate($this->getPaginate());
        }
        return $faqs;
    }

    public function getViewParams($id = 0)
    {
        $faq = new Faq();
        if ($id > 0) {
            $faq = $this->getModel()->findOrFail($id);
        }
       
        foreach (cache('LANGUAGES') as $lang) {

            if (is_null($faq->question)) {
                $faq->question = [];
                $faq->question += [$lang['short_code'] => ''];
            } else {
                if (!array_key_exists($lang['short_code'], $faq->question)) {

                    $faq->question += [$lang['short_code'] => ''];
                }
            }
            if (is_null($faq->answer)) {
                $faq->answer = [];
                $faq->answer += [$lang['short_code'] => ''];
            } else {
                if (!array_key_exists($lang['short_code'], $faq->answer)) {

                    $faq->answer += [$lang['short_code'] => ''];
                }
            }
        }



        return $faq;
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
        $faq = $this->getModel()->where('id', '=', $id)->firstOrFail();
        //        deleteImage($faq->getOriginal('image'));
        //        deleteImage($faq->getOriginal('detail_image'));
        $faq::destroy($id);
        return $faq;
    }
}
