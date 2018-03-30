<option value="<?= $category['id']?>" <?=($category['id']==$this->model->category_id)?"selected":""; ?>><?= $tab.$category['name'] ?></option>
<?php if(isset($category['childs'])):?>
    <?= $this->getMenuHtml($category['childs'], $tab.'&nbsp;&nbsp;&nbsp;---&nbsp;') ?>
    <option disabled></option>
<?php endif; ?>