<form id="check_import" style="min-width: 900px;" method="post" action="/song/push_song">

    <a href="/song/deleteNotMatched" style="color:red;">Удалить несопоставленные песни</a>

    <a href="/song/setAllUpdated" style="text-align: right;float:right;">set All Updated</a>
    <br/><br/>
    <div style="clear: both"></div>
    <div id="m1" style="border-right: 1px solid black;width: 49%">

        <div>Список новых песен</div>
        <table border="0" width="100%">
            <?php
            $firstName = $imported && $imported[0] ? $imported[0]->name : '';
            foreach ($imported as $i => $song) :
                ?>
                <tr>
                    <td>
                        <input type="radio" name="songNew" <?php if ($i === 0) { ?> checked<? } ?>
                               value="<?= $song->id ?>"/>
                        <a href="/song/view/<?= $song->id ?>" target="_blank"><?= $song->name ?></a>

                    </td>
                    <td>
                        <a href="/song/push_song/?songNew=<?= $song->id ?>&&songOld=new" style="color:green"> новая&nbsp;</a>
                    </td>
                    <td>
                        <a href="/song/delete/<?= $song->id ?>?r=/song/check_import" style="color:red">
                            удалить&nbsp;</a>
                    </td>
                    <td><a href="/search?q=<?=$song->name?>" target="_blank">Искать</a></td>
                </tr>
            <? endforeach; ?>
        </table>
    </div>
    <div id="m2" style="padding-left: 20px;width: 48%;">
        <div class="t1">Список необновленных песен</div>

        <?php
        $checked = false;
        foreach ($notUpdated as $song) :
            ?>
            <div class="t1">
                <input type="radio" <?php if ($firstName === $song->name && !$checked){
                $checked = true; ?>checked<?php } ?> name="songOld"
                       value="<?= $song->id ?>"/>
                <a target="_blank" href="/song/view/<?= $song->id ?>"><?= $song->name ?></a>
                <input type="submit" class="submitik" value="подтвердить"/>
            </div>

        <? endforeach; ?>
    </div>

</form>