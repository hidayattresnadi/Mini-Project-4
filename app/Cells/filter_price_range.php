  <!-- filter Price Range -->
  <div class="col-md-2">
      <label class="form-label mb-1">Filter by Price Range</label>
      <select name="price" class="form-control" onchange="this.form.submit()">
          <option value="">All Prices Range</option>
          <?php
            foreach ($priceRanges as $label => $range):
                $value = $range[0] . '-' . ($range[1] ?? 'above'); // Format value
            ?>
              <option value="<?= $value ?>" <?= ($params->price == $value) ? 'selected' : '' ?>>
                  <?= $label ?>
              </option>
          <?php endforeach; ?>
      </select>
  </div>