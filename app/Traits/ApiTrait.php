<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApiTrait {


    public function scopeIncluded(Builder $query) {     //queryscope

        if(empty($this->allowIncluded) || empty(request('included'))){
            return;
    
        }
    
        $relations = explode(',', request('included')); //video 14  /categories/1?included=posts
        $allowIncluded = collect($this->allowIncluded);
    
        foreach ($relations as $key => $relationship) {
            if(!$allowIncluded->contains($relationship)){
                unset($relations[$key]);
    
            }
        }
    
        $query->with($relations);
     
    }
    
    
    public function scopeFilter(Builder $query) {   // queryscope
    
        if(empty($this->allowFilter) || empty(request('filter'))){
            return;
        }
    
        $filters = request('filter');   //array q viene por  url en la variable "filter" (ej. \categories?filter[name]=jose) 
        $allowFilter = collect($this->allowFilter);    
    
        foreach($filters as $filter => $value){
            if($allowFilter->contains($filter)){
                $query->where($filter, 'LIKE', '%' . $value . '%');
    
            }
    
        }
    
    }
    
    
    public function scopeSort(Builder $query) {     // video 16
    
        if(empty($this->allowSort) || empty(request('sort'))){
            return;
        }
    
        $sortsFields = explode(',', request('sort')); 
        $allowSort = collect($this->allowSort);  
    
        foreach($sortsFields as $sortsField) {
    
            $direction = 'asc';
    
            if(substr($sortsField, 0, 1) == '-') {
                $direction = 'desc';
                $sortsField = substr($sortsField, 1);
            }
    
    
            if($allowSort->contains($sortsField)) {
                $query->orderBy($sortsField, $direction); 
            }
    
        }
    
    }
    
    public function scopegetOrPaginate(Builder $query) {
    
            if(request('perPage')) {
                $perPage = intval(request('perPage'));
    
                if($perPage) {
                    return $query->paginate($perPage);
                }
    
            }
            
            return $query->get();
    }


}

