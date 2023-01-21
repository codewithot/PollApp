<?php



/** @var yii\web\View $this */

$this->title = 'Poll App';

?>

<body>
<?php if(isset($_POST['submit'])): ?>

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <?php foreach($result as $results): ?>
        <div class="p-3 border-t border-gray-200 dark:border-gray-700 md:border-l">
            <div class="flex items-center">
                <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white"><?=$results['party_abbreviation']?></div>
            </div>

            <div class="ml-12">
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                    <?= $results['score'] ?> </div>
            </div>
        </div>
<?php endforeach; ?>
    </div>
</div>
<?php endif;?>
</body>



