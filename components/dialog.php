<?php
function dialog()
{
    return '
<dialog class="navbar-dialog cream shadow border rounded-lg">
    <div class="p-c border-b grid grid-cols-3">
        <div class="flex gap-3 items-center">
            <div class="w-5 h-5 rounded-full shadow border red"></div>
            <div class="w-5 h-5 rounded-full shadow border yellow"></div>
            <div class="w-5 h-5 rounded-full shadow border green"></div>
        </div>
        <h2 class="text-center font-bold dialog-title"></h2>
        <button class="text-end font-medium" onclick="cancel()">Cancel</button>
    </div>
    <div class="p-c flex flex-col gap-6 items-center">
        <div class="w-full text-center dialog-prompt"></div>
        <div class="flex gap-6 items-center">
            <button class="btn-no px-6 py-4 rounded-lg shadow border red" onclick="cancel()">No</button>
            <button class="btn-yes px-6 py-4 rounded-lg shadow border green" onclick="confirm()">Yes</button>
        </div>
    </div>
</dialog>
';
}
?>