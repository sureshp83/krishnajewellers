<form id="deleteForm" name="deleteForm" action="" method="post">
    @csrf
    <input type="text" name="password" id="password">
    @method('delete')
</form>

<form id="changeStatusForm" name="changeStatusForm" action="" method="post">
    @csrf
</form>

<form id="changeRailsAccount" name="changeRailsAccount" action="" method="post">
    @csrf
</form>

<form id="changeVerificationAccount" name="changeVerificationAccount" action="" method="post">
    @csrf
</form>