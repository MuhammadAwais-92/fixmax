<?php


namespace App\Http\Repositories;

use App\Http\Dtos\SendEmailDto;
use App\Http\Dtos\SubscriptionUpdateDto;
use App\Http\Dtos\UserDto;
use App\Http\Dtos\UserFeatureSubscriptionSaveDto;
use App\Http\Libraries\DataTable;
use App\Http\Repositories\BaseRepository\Repository;
use App\Jobs\SendMail;
use App\Models\UserFeaturedSubscription;
use App\Models\User;
use App\Traits\EMails;
use Carbon\Carbon;
use ErrorException;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use Spatie\DataTransferObject\DataTransferObject;

class UserFeaturedSubscriptionRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new UserFeaturedSubscription());
    }

    /**
     * @throws Exception
     */
    public function save(UserFeatureSubscriptionSaveDto $params)
    {
        DB::beginTransaction();
        try {
            $data = $params->except( 'id')->toArray();
//            dd($data, $params->id);
            $subscription = $this->getModel()->updateOrCreate(['id'=>$params->id],$data);
            DB::commit();
            return $subscription;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function get($id = 0){
        $package = $this->getModel();
        if ($id > 0){
            $package = $this->getModel()->select($this->getSelect())->find($id);
        }
        if (!is_null($package)){
            if (is_null($package->name)) {
                $package->name = ['en' => '', 'ar' => ''];
            }
            if (is_null($package->description)) {
                $package->description = ['en' => '', 'ar' => ''];
            }
        }
        return $package;
    }

    public function adminDataTable($columns){

        DataTable::init(new SubscriptionPackage(), $columns);
        $articles = DataTable::get();
        $start = 1;
        if ($articles['meta']['start'] > 0 && $articles['meta']['page'] > 1){
            $start = $articles['meta']['start'] + 1;
        }
        $count = $start;

        if (sizeof($articles['data']) > 0) {
            $dateFormat = config('settings.date-format');
            foreach ($articles['data'] as $key => $article) {
//                $count = $count + 1;
                $articles['data'][$key]['count'] = $count ++;
                $articles['data'][$key]['name'] = ucwords($article['name']['en']);
                $articles['data'][$key]['description'] = $article['description']['en'];
                $articles['data'][$key]['duration'] = $article['duration'].' '.$article['duration_type'];
                $articles['data'][$key]['type'] = $article['subscription_type'];
                $articles['data'][$key]['duration_type'] = $article['duration_type'];
                $articles['data'][$key]['price'] = $article['price'];
                $articles['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.subscriptions.edit', $article['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-article-button" href="javascript:{};" data-url="' . route('admin.dashboard.subscriptions.destroy', $article['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
            }
        }



        return $articles;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $object = $this->get($id);
            if ($object->delete()) {

                DB::commit();
                return true;
            }else{
                throw new Exception('Unable to delete');
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }






    }

    public function all(array $type = ['supplier', 'free','featured']){
        $query = $this->getQuery();
        $query->whereIn('subscription_type', $type);
        if ($this->getPaginate() > 0){
            return $query->select($this->getSelect())->paginate($this->getPaginate());
        }else{
            return $query->select($this->getSelect())->get();
        }
    }


}
