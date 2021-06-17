<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

trait ApiResponser{
	protected function successResponse($data,$code)
	{
		return response()->json($data,$code);
	}

	protected function errorResponse($message,$code)
	{
		return response()->json(["error"=>$message,"code"=>$code]);
	}

	//return a list of elements of a model
	protected function showCollectionAsResponse(Collection $collection,$code=200)
	{
		if($collection->isEmpty())
		{
			return $this->successResponse(["data"=>$collection],$code);
		}
		$transformer=$collection->first()->transformer;
		$collection=$this->filterData($collection,$transformer);
		$collection=$this->sortData($collection,$transformer);
		$collection=$this->paginate($collection);
		$collection=$this->transformData($collection,$transformer);
		//$collection=$this->cacheResponse($collection);//uncomment to enable caching
		return $this->successResponse(["data"=>$collection],$code);
	}

	//return a single element of a model
	protected function showModelAsResponse(Model $model,$code=200)
	{
		$transformer=$model->transformer;
		$model=$this->transformData($model,$transformer);
		return $this->successResponse(["data"=>$model],$code);
	}

	protected function filterData(Collection $collection,$transformer)
	{
		foreach(request()->query() as $query=>$value )
		{
			$attribute=$transformer::getOriginalField($query);
			if(isset($attribute,$value)){
				$collection=$collection->where($attribute,$value);
			}
		}
		return $collection;
	}

	protected function sortData(Collection $collection,$transformer)
	{
		if(request()->has('sort_by'))
		{
			$attribute=$transformer::getOriginalField(request()->sort_by);
			$collection=$collection->sortBy($attribute);
		}
		return $collection;
	}

	protected function paginate(Collection $collection)
	{
		$rules=[
			'perPage'=>'integer|min:2|max:50'
		];
		Validator::validate(request()->all(),$rules);
		$page=LengthAwarePaginator::resolveCurrentPage();
		$perPage=15;
		if(request()->has('perPage'))
		{
			$perPage=(int)request()->perPage;
		}
		$results=$collection->slice(($page-1)*$perPage,$perPage)->values();
		$paginated=new LengthAwarePaginator($results,$collection->count(),$perPage,$page,[
			"path"=>LengthAwarePaginator::resolveCurrentPath(),
		]);
		$paginated->append(request()->all());
		return $paginated;
	}


	/*
	caching data
	protected function cacheResponse($data)
	{
		$url=request()->url();
		$queryParams=request()->query();
		ksort($queryParams);
		$queryString=http_build_query($queryParams);
		$fullUrl=$url.$queryString;
		return Cache::remember($fullUrl,30,function() use($data){
					return $data;
		});
	}
	*/
	//uncomment to enable caching
	

	protected function transformData($data,$transformer)
	{
		return fractal($data, new $transformer)->toArray();
	
	}



}
?>