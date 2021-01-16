<?php

declare(strict_types=1);

namespace Api\Controller;

use Api\Model\ModelDevelopers;

class Developers extends Controller
{
    public function main(): void
    {
        $this->returnJson($this->responseArray(false, ['message' => 'Sistema Funcionando!']));
    }

    private function returnTableFieldNames(array $data): array
    {
        $array = [
            'id' => 'id',
            'name' => 'nome',
            'gender' => 'sexo',
            'hb' => 'hobby',
            'birthdate' => 'datanascimento',
        ];
        $newArray = [];
        $result = array_diff_key($data, $array);
        if (count($result)) {
            return ['erro' => true];
        }
        foreach ($array as $key => $value) {
            if (!empty($data[$key])) {
                $newArray[$value] = $data[$key] ?? null;
            }
        }
        return $newArray;
    }

    public function getAll(): void
    {
        $data = $this->getRequestData();
        unset($data['url']);
        $result = $this->responseArray(true, ['message' => 'Operação inválida!']);
        if ($this->getMethod() === 'GET') {
            if (count($data)) {
                $data2 = $this->returnTableFieldNames($data);
                if (!empty($data2['erro'])) {
                    $this->returnJson($result);
                }
                $result = $this->responseArray(false, ['developers' => (new ModelDevelopers())->getFilter($data2)]);
                $this->returnJson($result);
            }
            $result = $this->responseArray(false, ['developers' => (new ModelDevelopers())->getAll()]);
            $this->returnJson($result);
        }
    }

    public function findById(int $id): void
    {
        $result = $this->responseArray(true, ['message' => 'Operação inválida!']);
        if ($this->getMethod() === 'GET') {
            $result = $this->responseArray(false,  ['developer' => (new ModelDevelopers())->findById($id)]);
        }
        $this->returnJson($result);
    }

    public function registerDeveloper(): void
    {
        $result = $this->responseArray(true, ['message' => 'Operação inválida!']);
        if ($this->getMethod() === 'POST') {
            $data = $this->returnTableFieldNames($this->getRequestData());
            unset($data['id']);
            if (empty($data)) {
                $this->returnJson($this->responseArray(true, ['message' => 'Insira ao menos um dado!']));
            }
            $result = $this->responseArray(false,  ['message' => (new ModelDevelopers())->insert($data)]);
        }
        $this->returnJson($result);
    }

    public function updateDeveloper(int $id): void
    {
        $result = $this->responseArray(true, ['message' => 'Operação inválida!']);
        if ($this->getMethod() === 'PUT') {
            $data = $this->returnTableFieldNames($this->getRequestData());
            $data['id'] = $id;
            if (empty($data)) {
                $this->returnJson($this->responseArray(true, ['message' => 'Insira ao menos um dado!']));
            }
            $result = $this->responseArray(false,  ['message' => (new ModelDevelopers())->update($data)]);
        }
        $this->returnJson($result);
    }

    public function deleteDeveloper(int $id): void
    {
        $result = $this->responseArray(true, ['message' => 'Operação inválida!']);
        if ($this->getMethod() === 'DELETE') {
            if (empty($id)) {
                $this->returnJson($this->responseArray(true, ['message' => 'Informe o id a ser excluído!']));
            }
            $result = $this->responseArray(false, (new ModelDevelopers())->delete($id));
        }
        $this->returnJson($result);
    }
}
