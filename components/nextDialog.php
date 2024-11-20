
<?php
function nextDialog($url)
{
  return '
<dialog class="next-navbar-dialog cream shadow border rounded-lg">
    <div class="p-c border-b grid grid-cols-3">
        <div class="flex gap-3 items-center">
            <div class="w-5 h-5 rounded-full shadow border red"></div>
            <div class="w-5 h-5 rounded-full shadow border yellow"></div>
            <div class="w-5 h-5 rounded-full shadow border green"></div>
        </div>
        <h2 class="text-center font-bold next-dialog-title"></h2>
    </div>
    <div class="p-c flex flex-col gap-6 items-center">
        <div class="w-full text-center next-dialog-prompt"></div>
        <div class="flex gap-6 items-center">
            <button class="btn-yes px-6 py-4 rounded-lg shadow border green" onclick="nextConfirm(\'' . $url . '\')">OK</button>
        </div>
    </div>
</dialog>
';
}
?>
