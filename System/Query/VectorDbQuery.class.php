<?php
namespace System\Query;

/**
 * 关系型缓存DB 性状
 */
trait VectorDbQuery
{
    private $dbLayer;//数据层

    public function add($data)
    {
        $result = $this->dbLayer->insert($data);
        if (!$result) {
            return false;
        }
        return $result;
    }

    public function delete(array $condition)
    {
        $row = $this->dbLayer->delete($condition);
        if (!$row) {
            return false;
        }
    }

    /**
     * 使用mysql数据库查询
     */
    public function find(string $condition, int $offset, int $size)
    {
        //可能需要一次查出所有关系
        if ($size > 0) {
            $condition = $condition.' LIMIT '.$offset.','.$size;
        }
        return $this->dbLayer->select($condition, $this->primaryKey);
    }
}
