<?php if (isset($errors) && !empty($errors)):?>
    <?php foreach ($errors as $field => $messages): ?>

        <?php $errors->$field = '
            <ul class="parsley-errors-list">
                <li class="">'.(implode("<br>", (array) $messages)).'</li>
            </ul>
        '; ?>

    <?php endforeach; ?>
<?php endif; ?>