<?php


namespace App\Http\Repositories;

use App\Http\Libraries\DataTable;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;

use function request;


class GalleryRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new Gallery());
    }

    public function getDataTable($columns)
    {
        DataTable::init(new Gallery(), $columns);
        $name = request('datatable.query.heading', '');

        if (!empty($name)) {
            DataTable::where('name', 'LIKE', '%' . addslashes($name) . '%');
        }

        $galleries = DataTable::get();
        $dateFormat = config('settings.date-format');

        $start = 1;
        if ($galleries['meta']['start'] > 0 && $galleries['meta']['page'] > 1) {
            $start = $galleries['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($galleries['data']) > 0) {
            foreach ($galleries['data'] as $key => $data) {
                $data['count'] = $count++;
                $data['image'] = '<img style="float: left;width:  100px;height: 100px;object-fit: cover;" src="' . env('APP_URL') .$data['image'] . '">';

                $data['actions'] = '<a href="' . route('admin.dashboard.galleries.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.galleries.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';

                $galleries['data'][$key] = $data;
            }
        }
        return $galleries;
    }


    public function all()
    {
        if ($this->getPaginate() == 0) {
            $galleries = $this->getModel()->latest()->get();
        } else {
            $galleries = $this->getModel()->latest()->paginate($this->getPaginate());
        }
        return $galleries;
    }

    public function getViewParams($id = 0)
    {
        $faq = new Gallery();
        if ($id > 0) {
            $faq = $this->getModel()->findOrFail($id);
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
