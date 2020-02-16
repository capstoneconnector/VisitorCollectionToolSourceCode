<?php


interface DbManagerInterface
{
    public function readById(int $id);
    public function insert();
    public function update();
    public function delete();

}