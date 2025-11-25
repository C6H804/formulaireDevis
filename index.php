<?php 
if (!isset($_SESSION)) {
    session_start();
} else {
    if (isset($_SESSION['formResult'])) {
        echo "<script>console.log(" . json_encode($_SESSION['formResult']) . ");</script>";
    }
}
// detect http://localhost:8000/index.php?error=validation
if (isset($_GET['error']) && $_GET['error'] === 'validation') {
    echo "<script>alert(" . json_encode($_SESSION['formError']) . ");
    window.location.href = 'index.php';
    </script>";
}

$formData = [];
require_once 'components/page/header.php';
require_once 'components/utils/__createInput.php';
require_once 'components/page/formHeader.php';

require_once 'components/page/formBody.php';

require_once 'components/api/anlyzeData.php';

?>


<?php
require_once 'components/page/formFooter.php';
require_once 'components/page/footer.php';
?>