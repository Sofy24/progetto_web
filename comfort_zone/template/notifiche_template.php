<?php
    if (($templateParams["id_start"] < 1) or ($templateParams["id_start"] > count($templateParams["notifiche"]))) {
        $templateParams["id_start"] = 1; 
    }
    $link1 = "location.href='notifiche.php?username=".$_SESSION['user']."&id_start=".($templateParams['id_start'] - 15)."'";
    $link2 = "location.href='notifiche.php?username=".$_SESSION['user']."&id_start=".($templateParams['id_start'] + 15)."'";
?>

<div class="notification">
    <h2>Le mie Notifiche</h2>

    <button onclick="<?php echo $link1 ;?>" <?php if ($templateParams["id_start"] == 1){echo "disabled";};?>><span class="glyphicon glyphicon-chevron-left" aria-label="indietro"></span></button>
    
    <label><?php echo $templateParams["id_start"]."-".($templateParams["id_start"] + 14);?></label>

    <button onclick="<?php echo $link2 ;?>" <?php if ($templateParams["id_start"] + 15 >= count($templateParams["notifiche"])){echo "disabled";};?>><span class="glyphicon glyphicon-chevron-right" aria-label="avanti"></span></button>

    <?php
        $startpoint = $templateParams["id_start"];
        $counter = 0;
        $iterate = 0;
        foreach($templateParams["notifiche"] as $notifica): ?>
        <?php
            $iterate += 1;
            if($iterate < $startpoint ) {
                continue;
            }
        ?>
        <div <?php if ($notifica["letta"] == 0){echo 'class="new-notification"';};?>>
            <div class="notification-text">
            
                <label><?php if ($notifica["letta"] == 0){echo "(nuova)";} ;?> Da: <?php echo $notifica["username_sender"];?></label>   
                <p><?php echo $notifica["testo"];?></p> 
            </div>
        </div>
    <?php
        $counter += 1;
        if ($counter % 15 == 0) {
            break;
        } 
        endforeach; ?>
</div>
<?php $dbh->markAsRead($_SESSION["user"]) ;?>

