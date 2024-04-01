<?php

namespace App;

class App{
    protected array $filters = [];

    public function registerFilters(array $filters): void {
        $this->filters = $filters;
    }

    public function filters(?array $list = []) : array {
        if(!empty($list)){
            $sp_filters = [];
            foreach($list as $id){
                $sp_filters[] = $this->filter($id);
            }
            return $sp_filters;
        }else {
            return $this->filters;
        }
    }
    public function filter(int $id){
        return $this->filters[$id];
    }
}