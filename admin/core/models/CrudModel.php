<?php
declare(strict_types=1);

class CrudModel {
    private PDO $pdo;
    private string $table;

    public function __construct(PDO $pdo, string $tableName) {
        $this->pdo = $pdo;
        $this->table = str_replace('`', '', $tableName);
    }

    public function getSchema(): array {
        $stmt = $this->pdo->prepare("SHOW FULL COLUMNS FROM `{$this->table}`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(int $limit = 50): array {
        $schema = $this->getSchema();
        $hasId = false;
        foreach ($schema as $c) {
            if ($c['Field'] === 'id') $hasId = true;
        }
        $order = $hasId ? "ORDER BY id DESC" : "";
        
        $stmt = $this->pdo->query("SELECT * FROM `{$this->table}` $order LIMIT $limit");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM `{$this->table}` WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM `{$this->table}` WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function insert(array $postData): bool {
        global $slugFields;
        if (isset($slugFields)) {
            foreach ($slugFields as $target => $source) {
                if (isset($postData[$source])) {
                    $postData[$target] = self::slugify((string)$postData[$source]);
                }
            }
        }

        $schema = $this->getSchema();
        $data = [];
        $columns = [];
        $placeholders = [];
        
        foreach ($schema as $col) {
            $field = $col['Field'];
            if ($field === 'id' || strpos((string)$col['Extra'], 'auto_increment') !== false) {
                continue; 
            }
            if (strtolower($field) === 'created_at' || strtolower($field) === 'updated_at') {
                $columns[] = "`$field`";
                $placeholders[] = ":$field";
                $data[$field] = date('Y-m-d H:i:s');
                continue;
            }
            if (isset($postData[$field])) {
                $columns[] = "`$field`";
                $placeholders[] = ":$field";
                $val = $postData[$field];
                $data[$field] = is_array($val) ? json_encode($val) : $val;
            }
        }
        
        if (empty($columns)) return false;
        
        $sql = "INSERT INTO `{$this->table}` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(int $id, array $postData): bool {
        global $slugFields;
        if (isset($slugFields)) {
            foreach ($slugFields as $target => $source) {
                if (isset($postData[$source])) {
                    $postData[$target] = self::slugify((string)$postData[$source]);
                }
            }
        }

        $schema = $this->getSchema();
        $data = ['id' => $id];
        $updateSet = [];
        
        foreach ($schema as $col) {
            $field = $col['Field'];
            if (strtolower($field) === 'id' || strpos((string)$col['Extra'], 'auto_increment') !== false || strtolower($field) === 'created_at') {
                continue; 
            }
            if (strtolower($field) === 'updated_at') {
                $updateSet[] = "`$field` = :$field";
                $data[$field] = date('Y-m-d H:i:s');
                continue;
            }
            if (isset($postData[$field])) {
                $updateSet[] = "`$field` = :$field";
                $val = $postData[$field];
                $data[$field] = is_array($val) ? json_encode($val) : $val;
            }
        }
        
        if (empty($updateSet)) return false;
        
        $sql = "UPDATE `{$this->table}` SET " . implode(', ', $updateSet) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function getPaginated(int $page, int $limit, array $where = []): array {
        $offset = ($page - 1) * $limit;
        
        // Dynamic ordering: check if table has sort_order, else default to id DESC
        $orderBy = 'id DESC';
        $schema = $this->getSchema();
        foreach ($schema as $col) {
            if (strtolower($col['Field']) === 'sort_order') {
                $orderBy = 'sort_order ASC, id ASC';
                break;
            }
        }
        
        $sql = "SELECT * FROM `{$this->table}`";
        $conditions = [];
        $params = [];
        
        foreach ($where as $field => $val) {
            if ($val === null) {
                $conditions[] = "`$field` IS NULL";
            } elseif (is_array($val) && array_key_exists('not', $val) && $val['not'] === null) {
                $conditions[] = "`$field` IS NOT NULL";
            } else {
                $conditions[] = "`$field` = :$field";
                $params[$field] = $val;
            }
        }
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY {$orderBy} LIMIT :limit OFFSET :offset";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        foreach ($params as $field => $val) {
            $stmt->bindValue(":$field", $val);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(array $where = []): int {
        $sql = "SELECT COUNT(*) FROM `{$this->table}`";
        $conditions = [];
        $params = [];
        
        foreach ($where as $field => $val) {
            if ($val === null) {
                $conditions[] = "`$field` IS NULL";
            } elseif (is_array($val) && array_key_exists('not', $val) && $val['not'] === null) {
                $conditions[] = "`$field` IS NOT NULL";
            } else {
                $conditions[] = "`$field` = :$field";
                $params[$field] = $val;
            }
        }
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $field => $val) {
            $stmt->bindValue(":$field", $val);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public static function slugify(string $text): string {
        // Replace non-letters/digits with hyphens
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // Trim hyphens
        $text = trim($text, '-');
        // Remove duplicate hyphens
        $text = preg_replace('~-+~', '-', $text);
        // Convert to lowercase
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }
}
