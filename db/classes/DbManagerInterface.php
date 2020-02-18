<?php


interface DbManagerInterface
{
    public function readById(array $ids);
    public function insert();
    public function update();
    public function delete();

}