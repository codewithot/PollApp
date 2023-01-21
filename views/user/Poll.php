<?php




/** @var yii\web\View $this */

$this->title = 'Poll App';

?>
<body>

<?php if ($lga): ?>

<form method="POST" action="./return-result">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <select name="lga" class="form-select" aria-label="Default select example">
        <option value=""selected>Click to select local Government</option>
        <?php foreach ($lga as $lgas): ?>
        <option value="<?=$lgas['uniqueid']?>"><?=$lgas['lga_name']?></option>
        <?php endforeach; ?> </select>

    <select name="pu" class="form-select" aria-label="Default select example">
        <option selected value="">Click to select Polling Unit</option>
        <option value="all">All</option>
        <?php foreach ($polling_unit as $unit): ?>
        <option value="<?= $unit['uniqueid']?>"> <?= $unit['polling_unit_name'] ?> </option>
        <?php endforeach; ?>
    </select>
    <input name='submit' type="submit">
</form>
<?php endif; ?>


</body>