<option><?= $category['name'] ?></option>
<?php if(isset($category['childs'])):?>
    <option>
        <?= $this->getMenuHtml($category['childs']) ?>
    </option>
<?php endif; ?>