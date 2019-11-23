<?php
// a file shared by all detail.php
// responsible to use the define data like exclude column, to do the detail.php page


$canEdit = checkAccess($baseName, 'edit');
?>
<div class="div-form">
    <div class="container body-content">
            
        <h2><?= ucfirst($baseName) ?> Details</h2>
        <?php
        $toLoop = $result;
        if(isset($excludeFromDetailColumn) && is_array($excludeFromDetailColumn)) {
            foreach ($excludeFromDetailColumn as $key => $value) {
                unset($toLoop[$value]);
            }
        }

        //used for column like CreatedBy and UpdatedBy to get the user name and id for if else statement
        $sql = 'select users.UserID, users.Username from users';
        $statement = $connection->prepare($sql);
        $statement->execute();
		$users = $statement->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <div class='div-form'>
            <dl class="dl-horizontal">
                <?php foreach($toLoop as $columnName => $value): ?>
                        <dt>
                            <?= $columnName ?>
                        </dt>
                        <dd>
                            <?php if($value != null):?>
                                <?php if($columnName === 'CreatedBy' || $columnName === 'UpdatedBy'):?>
                                    <?php foreach($users as $index => $user): ?>
                                        <?php if($user['UserID'] === $value):?>
                                            <?= $user['Username'] ?>
                                            <?php break; ?>
                                        <?php endif; ?>     
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php if (preg_match('/(\.jpg|\.png|\.bmp)$/', $value)): ?>
                                        <div>
                                            <img src='<?= $value ?>'>
                                        </div>
                                    <?php else: ?>
                                        <?= $value ?>
                                    <?php endif; ?>     
                                <?php endif; ?>     
                            <?php else: ?>
                                <?= '(not set)' ?>
                            <?php endif; ?>     
                        </dd>
                <?php endforeach; ?>
            </dl>
        </div>
        <br/>
        <div>
        <?php if($canEdit): ?>
            <a href="/test/public/<?= $baseName ?>/edit.php?id=<?= $paramID?>" class="btn btn-primary">Edit</a>
        <?php endif; ?>     
            <a href="/test/public/<?= $baseName ?>/index.php" class="btn btn-warning">Back to index</a>
        </div>

    </div>
</div>