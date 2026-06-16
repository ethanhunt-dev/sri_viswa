<?php
// Requires variables: $schema, $actionUrl, $editData
?>
<div class="admin-table-card" style="background:#fff; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,0.1); padding:20px; margin-bottom: 30px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 style="margin:0; font-family:'Outfit', sans-serif;">Edit Record</h3>
        <a href="<?= htmlspecialchars($actionUrl ?? '?') ?>" onclick="this.closest('.admin-table-card').style.display='none'; window.history.pushState({}, document.title, window.location.pathname); const addBtn = document.getElementById('add-btn'); if (addBtn) addBtn.style.display='inline-block'; return false;" style="color:#6b7280; text-decoration:none; font-size:14px; padding: 5px 10px; border: 1px solid #d1d5db; border-radius: 4px; background: #f9fafb;">Close</a>
    </div>
    
    <form method="post" action="<?= htmlspecialchars($actionUrl ?? '?') ?>" enctype="multipart/form-data" style="max-width: 600px;">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string)$editData['id']) ?>">
        
        <?php foreach ($schema as $col): ?>
            <?php 
                $field = $col['Field'];
                $type = strtolower($col['Type']);
                if (strtolower($field) === 'id' || strpos((string)$col['Extra'], 'auto_increment') !== false || strtolower($field) === 'created_at' || strtolower($field) === 'updated_at') continue;
                if (isset($hideInEdit) && in_array($field, $hideInEdit)) continue;
                
                // Hide parent_id field when editing main menus
                if ($field === 'parent_id' && isset($addMode) && $addMode === 'main') {
                    continue;
                }
                
                $label = isset($displayNames[$field]) ? $displayNames[$field] : ucwords(str_replace('_', ' ', $field));
                $val = (string)($editData[$field] ?? '');
                $inputStyle = 'width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; font-family: inherit; font-size: 14px; background: #f9fafb;';
                
                $isImage = (isset($imageFields) && in_array($field, $imageFields)) || (isset($images) && in_array($field, $images));
                $isDocument = (isset($documentFields) && in_array($field, $documentFields)) || (isset($documents) && in_array($field, $documents));
                
                // Determine text size and rich editor usage
                $isText = (strpos($type, 'text') !== false);
                $isLargeVarchar = false;
                if (preg_match('/varchar\((\d+)\)/i', $type, $matches)) {
                    if ((int)$matches[1] > 49) {
                        $isLargeVarchar = true;
                    }
                }
                
                $useRichEditor = false;
                if (isset($excludeCkEditor) && in_array($field, $excludeCkEditor)) {
                    $useRichEditor = false;
                } elseif (isset($richTextFields) && in_array($field, $richTextFields)) {
                    $useRichEditor = true;
                } else {
                    $useRichEditor = ($isText || $isLargeVarchar);
                }
                $isMultiline = $isText || $useRichEditor;
            ?>
            <label class="form-field" style="display:block; margin-bottom: 15px;">
                <span class="form-label" style="display:block; margin-bottom: 6px; font-weight:600; color:#374151;"><?= htmlspecialchars($label) ?></span>
                <?php if ($field === 'parent_id' && isset($parentMenus)): ?>
                    <select name="parent_id" class="form-input" style="<?= $inputStyle ?>">
                        <option value="">-- None (Main Menu) --</option>
                        <?php foreach ($parentMenus as $pm): ?>
                            <option value="<?= $pm['id'] ?>" <?= (int)$val === (int)$pm['id'] ? 'selected' : '' ?>><?= htmlspecialchars($pm['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif (isset($relations) && isset($relations[$field])): ?>
                    <?php 
                        $rel = $relations[$field];
                        $relRows = [];
                        try {
                            $relStmt = $pdo->query("SELECT `{$rel['value_col']}`, `{$rel['display_col']}` FROM `{$rel['table']}` ORDER BY `{$rel['display_col']}` ASC");
                            $relRows = $relStmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (Exception $e) {}
                    ?>
                    <select name="<?= htmlspecialchars($field) ?>" class="form-input" style="<?= $inputStyle ?>">
                        <option value="">-- Select --</option>
                        <?php foreach ($relRows as $rRow): ?>
                            <option value="<?= htmlspecialchars((string)$rRow[$rel['value_col']]) ?>" <?= (string)$val === (string)$rRow[$rel['value_col']] ? 'selected' : '' ?>><?= htmlspecialchars((string)$rRow[$rel['display_col']]) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif (isset($multipleChoiceFields) && in_array($field, $multipleChoiceFields)): ?>
                    <?php
                        $choices = [];
                        if (isset($val) && strpos($val, '[') === 0) {
                            $decoded = json_decode($val, true);
                            if (is_array($decoded)) {
                                $choices = $decoded;
                            }
                        }
                    ?>
                    <div class="multi-choice-container" data-field="<?= htmlspecialchars($field) ?>">
                        <div style="display: flex; gap: 5px; margin-bottom: 10px;">
                            <input type="text" class="form-input multi-choice-input" style="<?= $inputStyle ?>" placeholder="Add item...">
                            <button type="button" class="multi-choice-add-btn" style="padding: 10px 15px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Add</button>
                        </div>
                        <div class="multi-choice-list" style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <?php foreach ($choices as $choice): ?>
                                <div style="background: #e5e7eb; color: #374151; padding: 5px 10px; border-radius: 15px; font-size: 13px; display: flex; align-items: center; gap: 5px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    <span><?= htmlspecialchars($choice) ?></span>
                                    <input type="hidden" name="<?= htmlspecialchars($field) ?>[]" value="<?= htmlspecialchars($choice) ?>">
                                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #ef4444; font-weight: bold; padding: 0 4px; font-size: 14px;">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php elseif ($isImage): ?>
                    <?php if ($val): ?>
                        <div style="margin-bottom: 10px;">
                            <img src="<?= htmlspecialchars('../' . ltrim($val, '/')) ?>" alt="Current Image" style="max-height: 100px; max-width: 100%; border-radius: 4px;">
                            <br><small style="color:#6b7280;">Current file: <?= htmlspecialchars($val) ?></small>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="<?= htmlspecialchars($field) ?>" accept="image/*" class="form-input" style="<?= $inputStyle ?>">
                <?php elseif ($isDocument): ?>
                    <?php if ($val): ?>
                        <div style="margin-bottom: 10px;">
                            <a href="<?= htmlspecialchars('../' . ltrim($val, '/')) ?>" target="_blank" style="color: #2563eb; text-decoration: underline;">View Current Document</a>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="<?= htmlspecialchars($field) ?>" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" class="form-input" style="<?= $inputStyle ?>">
                <?php elseif ($isMultiline): ?>
                    <textarea name="<?= htmlspecialchars($field) ?>" class="form-input <?= $useRichEditor ? 'ckeditor-field' : '' ?>" rows="5" style="<?= $inputStyle ?>"><?= htmlspecialchars($val) ?></textarea>
                <?php elseif (strpos($type, 'date') !== false): ?>
                    <input type="date" name="<?= htmlspecialchars($field) ?>" class="form-input" style="<?= $inputStyle ?>" value="<?= htmlspecialchars($val) ?>">
                <?php elseif (strpos($type, 'int') !== false || strpos($type, 'decimal') !== false || strpos($type, 'float') !== false): ?>
                    <?php $minAttr = (strpos($type, 'unsigned') !== false) ? 'min="0"' : ''; ?>
                    <input type="number" step="any" <?= $minAttr ?> name="<?= htmlspecialchars($field) ?>" class="form-input" style="<?= $inputStyle ?>" value="<?= htmlspecialchars($val) ?>">
                <?php else: ?>
                    <input type="text" name="<?= htmlspecialchars($field) ?>" class="form-input" style="<?= $inputStyle ?>" value="<?= htmlspecialchars($val) ?>">
                <?php endif; ?>
                <?php 
                    $helpText = '';
                    if (isset($fieldHelpText) && isset($fieldHelpText[$field])) {
                        $helpText = $fieldHelpText[$field];
                    } elseif (!empty($col['Comment'])) {
                        $helpText = $col['Comment'];
                    }
                ?>
                <?php if (!empty($helpText)): ?>
                    <small style="display:block; margin-top:5px; color:#6b7280; font-size:12px; font-weight:normal;"><?= htmlspecialchars($helpText) ?></small>
                <?php endif; ?>
            </label>
        <?php endforeach; ?>
        
        <div style="display: flex; gap: 10px; align-items: center; margin-top: 20px;">
            <button class="form-submit" type="submit" style="background: #2563eb; color: #fff; padding: 12px 24px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; font-family:'Outfit', sans-serif; transition: background 0.2s;">Update Record</button>
            <a href="<?= htmlspecialchars($actionUrl ?? '?') ?>" onclick="this.closest('.admin-table-card').style.display='none'; window.history.pushState({}, document.title, window.location.pathname); const addBtn = document.getElementById('add-btn'); if (addBtn) addBtn.style.display='inline-block'; return false;" style="color: #4b5563; text-decoration: none; font-weight: 600; padding: 12px 24px; border: 1px solid #d1d5db; border-radius: 4px; background: #f3f4f6; font-family:'Outfit', sans-serif;">Back</a>
        </div>
    </form>
</div>

<?php
$hasCkEditor = false;
foreach ($schema as $col) {
    $field = $col['Field'];
    $type = strtolower($col['Type']);
    if (strtolower($field) === 'id' || strpos((string)$col['Extra'], 'auto_increment') !== false || strtolower($field) === 'created_at' || strtolower($field) === 'updated_at') continue;
    if (isset($hideInEdit) && in_array($field, $hideInEdit)) continue;
    
    $isText = (strpos($type, 'text') !== false);
    $isLargeVarchar = false;
    if (preg_match('/varchar\((\d+)\)/i', $type, $matches)) {
        if ((int)$matches[1] > 49) {
            $isLargeVarchar = true;
        }
    }
    
    $useRichEditor = false;
    if (isset($excludeCkEditor) && in_array($field, $excludeCkEditor)) {
        $useRichEditor = false;
    } elseif (isset($richTextFields) && in_array($field, $richTextFields)) {
        $useRichEditor = true;
    } else {
        $useRichEditor = ($isText || $isLargeVarchar);
    }
    
    if ($useRichEditor) {
        $hasCkEditor = true;
        break;
    }
}
?>
<?php if ($hasCkEditor): ?>
<style>
.ck-editor__editable_inline {
    min-height: 200px;
}
</style>
<script src="../assets/js/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.ckeditor-field').forEach(function(el) {
            ClassicEditor
                .create(el)
                .catch(function(error) {
                    console.error(error);
                });
        });
    });
</script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.multi-choice-container').forEach(container => {
        const fieldName = container.dataset.field;
        const input = container.querySelector('.multi-choice-input');
        const addBtn = container.querySelector('.multi-choice-add-btn');
        const list = container.querySelector('.multi-choice-list');
        
        const addPill = (val) => {
            if (!val.trim()) return;
            const pill = document.createElement('div');
            pill.style.cssText = 'background: #e5e7eb; color: #374151; padding: 5px 10px; border-radius: 15px; font-size: 13px; display: flex; align-items: center; gap: 5px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);';
            pill.innerHTML = `
                <span>${val.replace(/</g, "&lt;").replace(/>/g, "&gt;")}</span>
                <input type="hidden" name="${fieldName}[]" value="${val.replace(/"/g, '&quot;')}">
                <button type="button" style="background: none; border: none; cursor: pointer; color: #ef4444; font-weight: bold; padding: 0 4px; font-size: 14px;">&times;</button>
            `;
            pill.querySelector('button').addEventListener('click', () => pill.remove());
            list.appendChild(pill);
            input.value = '';
        };

        addBtn.addEventListener('click', () => addPill(input.value));
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addPill(input.value);
            }
        });
    });
});
</script>
