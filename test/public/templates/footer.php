<?php
// this file is responsive to create footer
?></body>
<?php if(isset($_SESSION['UserID'])): ?>
    </div>
    </div>
    <br/>
    <div class='footer'>
        <span>Copyright © <?= date('Y') ?> <strong> ABC Clinic</strong> All Rights Reserved.</span>
    </div>
<?php else: ?>
<?php endif; ?>
</html>