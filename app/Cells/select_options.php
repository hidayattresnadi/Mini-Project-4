 <!-- filter Categories -->
 <div class="<?= $style ?> ">
     <label class="form-label mb-1"><?= $label ?></label>
     <select name=<?= $paramsName ?> class="form-control" onchange="this.form.submit()">
         <?php if ($optionsValueNull): ?>
             <option value=""><?= $optionsSelectAll ?></option>
         <?php endif; ?>

         <?php foreach ($datas as $data): ?>
             <option value="<?= $data ?>" <?= (isset($accessField[0]) && $accessField[0] === $data) ? 'selected' : '' ?>><?= ucfirst($data) ?></option>
         <?php endforeach; ?>
     </select>
 </div>