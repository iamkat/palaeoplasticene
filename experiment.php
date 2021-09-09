<?php
// Page Header
require('header.php');
?>

<!-- Script Tag for Login Check -->
<script>
    <?php
    // Check for logged in user
    require('./js/ppcLoginCheck.js');
    ?>
</script>

<!-- Page Content -->
<main class="ppcMain">
    <article class="ppcContent">
        <h2>Experiment</h2>
        <form id="ppcExpForm">
        <fieldset>
            <legend>Experiment data</legend>
            <div class="ppcExpFormPart">
                <label for="ppcExpCat">Experiment category</label>
                <input type="text" id="ppcExpCat" name="ppcExpCat" value="" readonly required />
                <input type="hidden" id="ppcExpUser" name="ppcExpUser" value="" required />
            </div>
            <div class="ppcExpFormPart">
                <label for="ppcExpName">Experiment name</label>
                <input type="text" id="ppcExpName" name="ppcExpName" placeholder="e.g. Mushroom Experiment 1" pattern="[A-Za-z0-9\s]{4,32}" title="At least 4 digits of letters and numbers including whitespaces. Avoid special characters." required />
            </div>
            <div class="ppcExpFormPart">
                <label for="ppcExpLoc">Experiment location</label>
                <input type="text" id="ppcExpLoc" name="ppcExpLoc" placeholder="e.g. metropole, city, village, countryside" pattern="[A-Za-z0-9\s\u002C-\u002E\u003A\u0021\u003F]{4,256}" title="At least 4 digits of letters and numbers including whitespaces and punctuation. Avoid special characters." required />
            </div>
            <div class="ppcExpFormPart">
                <label for="ppxExpSurr">Experiment surroundings</label>
                <input type="text" id="ppcExpSurr" name="ppcExpSurr" placeholder="e.g. room, kitchen, terrace, garden" pattern="[A-Za-z0-9\s\u002C-\u002E\u003A\u0021\u003F]{4,512}" title="At least 4 digits of letters and numbers including whitespaces and punctuation. Avoid special characters." required />
            </div>
        </fieldset>
        <fieldset>    
        <legend>Images</legend>
            <div class="ppcExpFormPartImg">
                <!-- Task: IDs and names automatically and subsequently numbered as well as fetched from server -->
                <!-- Limit the maximum file size to 8 MB -->
                <input type="hidden" name="ppcExpImgFileSize" id="ppcExpImgFileSize" value="8192000" />
                <!--label for="ppcExpImg0001"><img class="ppcAdd" src="./assets/img/ppc_add.png" alt="Add Image" /></label-->
                <input type="file" class="ppcExpImg" id="ppcExpImg0001" name="ppcExpImg0001" accept="image/png, image/jpeg" title="Only PNG and JPG files accepted." />
                <div id="ppcUplImgPreview"></div>
                <label for="ppcImgDate">Date</label>
                <input type="date" id="ppcImgDate" name="ppcImgDate" placeholder="dd.mm.yyyy" title="Please specify the date the image was taken." />
                <label for="ppcImgCond">Conditions</label>
                <input type="text" id="ppcImgCond" name="ppcImgCond" placeholder="e.g. high humidity, direct exposure to the sun, freezing cold" pattern="[A-Za-z0-9\s\u002C-\u002E\u003A\u0021\u003F]{4,512}" title="At least 4 digits of letters and numbers including whitespaces and punctuation. Avoid special characters." />
                <label for="ppcExpImgView">Viewpoint</label>
                <select name="ppcExpImgView" id="ppcExpImgView" form="ppcExpForm">
                    <option>Front</option>
                    <option>Rear</option>
                    <option>Side</option>
                    <option>Top</option>
                    <option>Bottom</option>
                </select>
            </div>
        </fieldset>
        <div id="ppcExpControls" class="ppcExpFormPart">
                <input type="submit" id="ppcExpSubmit" class="ppcControl" name="ppcExpSubmit" value="Create" />
        </div>
        </form>
    </article>
</main>
<?php require('footer.php'); ?>