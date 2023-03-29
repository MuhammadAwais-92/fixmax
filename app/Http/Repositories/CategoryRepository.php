<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;


class CategoryRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new Category());
    }

    public function all($onlyParent = false)
    {
        $query = $this->getQuery();
        if ($onlyParent) {
            $query->where('parent_id', 0);
        }
        $categories = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        return $categories;
    }
    // front categories

    public function allCategories($onlyParent = false)
    {
        $query = $this->getQuery();
        if ($onlyParent) {
            $query->where('parent_id', 0)->has('subCategories');
        }
        if ($this->getPaginate() > 0) {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate());
        } else {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $services;
    }
    public function destroy($id)
    {
        $category = $this->get($id);
        $category->subCategories()->delete();
        $category::destroy($id);
        return $category;
    }

    public function save($params, $id)
    {
        DB::beginTransaction();
        try {
            $category = $this->getModel()->updateOrCreate(['id' => $id], $params);
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function get($id = 0)
    {
        $category = new Category();
        if ($id > 0) {
            $category = $this->getModel()->select($this->getSelect())->with($this->getRelations())->findOrFail($id);
        }

        foreach (cache('LANGUAGES') as $lang) {

            if (is_null($category->name)) {
                $category->name = [];
                $category->name += [$lang['short_code'] => ''];
            } else {
                if (!array_key_exists($lang['short_code'], $category->name)) {

                    $category->name += [$lang['short_code'] => ''];
                }
            }
        }

        return $category;
    }
    public function subcategories($id)
    {
        $query = $this->getQuery();
        $data = $query->where('parent_id', $id)->get();
        $startItem = [];
        $startItem['id'] = '';
        $startItem['name']['en'] = 'Select Delivery Area';
        $startItem['name']['ar'] = __('Select Delivery Area');
        $data->prepend($startItem);
        return $data;
    }
}
