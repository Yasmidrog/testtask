<?php
function months()
{
    return [
        'Декабря',
        'Января',
        'Февраля',
        'Марта',
        'Апреля',
        'Мая',
        'Июня',
        'Июля',
        'Августа',
        'Сентября',
        'Октября',
        'Ноября'
    ];
}

function sort_dates($a, $b)
{
    return $a->date > $b->date;
}

function view($notifications)
{
    usort($notifications, "sort_dates");
    $groups = array();
    foreach ($notifications as $n) {
        $key = (date("d", $n->date) * 1) . ' ' . months()[date("n", $n->date)];
        if (!isset($groups[$key])) {
            $groups[$key] = [$n];
        } else {
            $groups[$key][] = $n;
        }
    }
    foreach ($groups as $date => $narr) {
        ?>
        <div class="date_block">
            <h3 class="date_title"> <?php echo $date; ?></h3>
            <div class="notifs">
                <?php
                foreach ($narr as $n) {
                    element($n);
                } ?>
            </div>
        </div>
        <?php
    }
}

function element($n)
{
    ?>
    <div xmlns="http://www.w3.org/1999/html">
        <div class="notification">
            <div class="notimg">

                <img src="<?php echo $n->photo ?>" width="50px" height="50px">
            </div>
            <div class="about">
                <p><?php echo $n->name ?>

                </p>
                <p class="small"><?php echo date('m-d G:i', ($n)->date); ?>
                    <?php if (isset($_SESSION['last']) && $n->date > $_SESSION['last']) { ?>
                        <span>новое</span>
                    <?php } ?>
                </p>
            </div>
        </div>
        <?php
        ?>
    </div>
    <?php
}