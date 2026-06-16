<?php
// Requires variables: $schema, $rows, $privs, $hasId
?>
<?php if (empty($rows)): ?>
    <div class="admin-panel admin-panel--empty">
        <p class="admin-empty">No records found.</p>
    </div>
<?php else: ?>
    <div class="admin-table-card" style="background:#fff; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,0.1); padding:20px;">
        <h3 style="margin-top:0; margin-bottom: 20px; font-family:'Outfit', sans-serif;">Existing Records</h3>
        <div class="admin-table-wrap" style="overflow-x: auto;">
            <table class="admin-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <tr>
                        <?php foreach ($schema as $col): ?>
                            <?php 
                                $colName = $col['Field'];
                                if (isset($hideInList) && in_array($colName, $hideInList)) continue;
                                $displayName = isset($displayNames[$colName]) ? $displayNames[$colName] : ucwords(str_replace('_', ' ', $colName));
                            ?>
                            <th style="padding: 12px; font-weight: 600; color:#374151;"><?= htmlspecialchars($displayName) ?></th>
                        <?php endforeach; ?>
                        
                        <?php $showActions = $hasId && (!empty($privs['update']) || !empty($privs['delete'])); ?>
                        <?php if ($showActions): ?>
                            <th style="padding: 12px; font-weight: 600; color:#374151;">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <?php foreach ($schema as $col): ?>
                                <?php 
                                    $colName = $col['Field'];
                                    if (isset($hideInList) && in_array($colName, $hideInList)) continue;
                                    $val = (string)($row[$colName] ?? '');
                                    
                                    // Handle Relations mapping
                                    if (isset($relations) && isset($relations[$colName]) && $val !== '') {
                                        $rel = $relations[$colName];
                                        try {
                                            $stmt = $pdo->prepare("SELECT `{$rel['display_col']}` FROM `{$rel['table']}` WHERE `{$rel['value_col']}` = ?");
                                            $stmt->execute([$val]);
                                            $displayVal = $stmt->fetchColumn();
                                            if ($displayVal !== false) {
                                                $val = $displayVal;
                                            }
                                        } catch (Exception $e) {}
                                    }
                                    
                                    // Format Dates
                                    if ($val && (strtolower($colName) === 'created_at' || strtolower($colName) === 'updated_at' || strpos(strtolower($col['Type']), 'datetime') !== false || strpos(strtolower($col['Type']), 'timestamp') !== false)) {
                                        $val = date('M d, Y h:i A', strtotime($val));
                                    }
                                    
                                    // Handle Image display
                                    if ($val && (strpos(strtolower($colName), 'image') !== false || strpos(strtolower($colName), 'logo') !== false || strpos(strtolower($colName), 'pic') !== false)) {
                                        if (file_exists(__DIR__ . '/../../../' . ltrim($val, '/'))) {
                                            $val = '<img src="' . htmlspecialchars('../' . ltrim($val, '/')) . '" alt="Image" style="height: 40px; border-radius: 4px; object-fit: cover;">';
                                        }
                                    }
                                    
                                    // Handle JSON array (Multiple Choice fields)
                                    if (strpos($val, '[') === 0) {
                                        $decoded = json_decode($val, true);
                                        if (is_array($decoded)) {
                                            $val = implode(', ', $decoded);
                                        }
                                    }
                                    
                                    if (strpos($val, '<img') !== 0) {
                                        $val = strip_tags($val);
                                        if (strlen($val) > 60) $val = substr($val, 0, 60) . '...';
                                    }
                                ?>
                                <td style="padding: 12px; font-size: 14px; color: #4b5563;"><?= $val ?></td>
                            <?php endforeach; ?>
                            
                            <?php if ($showActions): ?>
                                <td style="padding: 12px; white-space: nowrap;">
                                    <?php if (!empty($privs['update'])): ?>
                                        <a href="?edit=<?= htmlspecialchars((string)($row['id'] ?? '')) ?>" style="color: #2563eb; text-decoration: underline; margin-right: 15px; font-size: 14px;">Edit</a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($privs['delete'])): ?>
                                        <form method="post" action="?" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars((string)($row['id'] ?? '')) ?>">
                                            <button type="submit" style="color: #dc2626; background: none; border: none; cursor: pointer; text-decoration: underline; font-size: 14px; padding:0;">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
        
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <?php
                // Safe page url generator
                $pageUrl = function(int $pageNum) {
                    $params = $_GET;
                    $params['p'] = $pageNum;
                    return '?' . http_build_query($params);
                };
            ?>
            <div class="admin-pagination" style="margin-top: 20px; display: flex; gap: 5px; justify-content: center; align-items: center; font-family: inherit;">
                <?php if ($page > 1): ?>
                    <a href="<?= $pageUrl($page - 1) ?>" style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; text-decoration: none; color: #374151; background: #fff; font-size: 13px;">&laquo; Prev</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="<?= $pageUrl($i) ?>" style="padding: 8px 12px; border: 1px solid <?= $i === $page ? '#2563eb' : '#d1d5db' ?>; background: <?= $i === $page ? '#2563eb' : '#fff' ?>; color: <?= $i === $page ? '#fff' : '#374151' ?>; border-radius: 4px; text-decoration: none; font-weight: <?= $i === $page ? '600' : 'normal' ?>; font-size: 13px;"><?= $i ?></a>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages): ?>
                    <a href="<?= $pageUrl($page + 1) ?>" style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; text-decoration: none; color: #374151; background: #fff; font-size: 13px;">Next &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
