<table class="grid-view summary-table">
    <tr>
        <?php foreach($tableHeader as $indexArraySelected => $header): ?>
            <th><?= str_replace(' ', '<br>', $header) ?></th>
        <?php endforeach; ?>
    </tr>

    <?php if(!$result): ?>
        <tr>
            <td colspan=12> No result Found. </td>
        </tr>
    <?php else: ?>
        <?php foreach($result as $key => $value): ?>
            <tr>
                <?php foreach($value as $key2 => $value2): ?>
                    <td>
                        <?php if ($value2 == null ): ?> 
                            <span> <?= '(not set)' ?> </span>
                        <?php else:?>
                            <span> <?= $value2 ?> </span>
                        <?php endif;?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
