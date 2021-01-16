<?php

declare(strict_types=1);

namespace Api\Model;

class ModelDevelopers extends Model
{
    private function bind($sql, $data)
    {
        $bind = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            gettype($v) == 'int' ? $bind->bindValue(':' . $k, $v, \PDO::PARAM_INT)
                : $bind->bindValue(':' . $k, "$v", \PDO::PARAM_STR);
        }
        return $bind;
    }

    private function bindLike($sql, $data)
    {
        $bind = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            gettype($v) == 'int' ? $bind->bindValue(':' . $k, $v, \PDO::PARAM_INT)
                : $bind->bindValue(':' . $k, "%$v%", \PDO::PARAM_STR);
        }
        return $bind;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $developers = $stmt->fetchAll() ?? [];
        
        if (count($developers)) {
            http_response_code(200);
            return $developers;
        }
        http_response_code(404);
        return ['Nennhum developer não encontrado!'];

        
    }

    public function getFilter(array $data): array
    {
        $result =  $this->where($data, ' LIKE ');
        if (count($result)) {
            http_response_code(200);
            return $result;
        }
        http_response_code(404);
        return ['Nennhum developer não encontrado!'];
    }

    public function findById(int $id): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            http_response_code(200);
            return $stmt->fetch();
        }
        http_response_code(404);
        return ['Developer não encontrado!'];
    }

    public function insert(array $data): array
    {
        try {
            $sql = "INSERT INTO {$this->table} (" . implode(',', array_keys($data)) . ") VALUES (:" . implode(', :', array_keys($data)) . ")";
            $stmt = $this->bind($sql, $data);
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                http_response_code(201);
                return ['message' => 'Registro salvo com sucesso!'];
            }
            http_response_code(400);
            return ['message' => 'Registro não inserido!'];
        } catch (\PDOException $e) {
            http_response_code(400);
            return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
        }
    }

    public function update(array $data): array
    {
        try {
            if (empty($data['id'])) {
                throw new \Exception('ID não encontrado!', 286);
            }

            $datasSql = '';

            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $datasSql .= $key . ' = ' . ':' . $key . ', ';
                }
            }

            $datasSql = substr($datasSql, 0, -2);

            $sql = "UPDATE " . $this->table . " SET " . $datasSql . " WHERE id = :id";
            $stmt = $this->bind($sql, $data);
            if ($stmt->execute()) {
                http_response_code(200);
                return ['message' => 'Registro atualizado com sucesso!'];
            }
            http_response_code(400);
            throw new \Exception('Falha ao atualizar registro!', 2);
        } catch (\PDOException $e) {
            return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
        }
    }

    public function delete(int $id): array
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $delete = $this->bind($sql, ['id' => $id]);
            if ($delete->execute() && $delete->rowCount() > 0) {
                http_response_code(204);
                return ['message' => 'Registro excluído com sucesso!'];
            }
            http_response_code(400);
            return ['erro' => true, 'message' => 'Registro não encontrado!'];
        } catch (\PDOException $e) {
            return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
        }
    }

    public function where(array $conditions, $operator = ' = ', $fields = '*'): array
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->table . ' WHERE ';
        $binds = array_keys($conditions);
        $where  = null;
        foreach ($binds as $v) {
            $where .= $operator === ' LIKE ' ?
                $v . $operator . ':' . $v . ' and ' :
                $v . $operator . ':' . $v . ' and ';
        }
        $sql .= $where;
        $sql = substr($sql, 0, -4);
        $get = $this->bindLike($sql, $conditions);
        $get->execute();
        return $get->fetchAll();
    }
}
