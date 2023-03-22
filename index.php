<form
        id="form"
        class="form"
        action="handler.php"
        enctype="multipart/form-data"
        method="POST"
>
    <div>
        <label for="content">Content</label>
    </div>

    <textarea
            id="content"
            class="content"
            name="content"
            rows="10"
    ></textarea>


    <div style="text-align: center; margin-top: 10px">
        <button type="submit" onclick="loading(this)">Click</button>
    </div>

    <div>
        <label for="result">Result</label>
    </div>
	<?php
	$result = $_GET['result'] ?? '';
	echo '<textarea id="result" class="result" name="result" rows="10">'.$result.'</textarea>';
	?>
    <button style="float:right" type="button" onclick="copyResult()">Copy</button>

</form>

<style>
    .form {
        width: 50%
    }

    .content,
    .result {
        width: 100%;
    }
</style>

<script>
    function loading(event) {
        event.disabled = true;
        document.getElementById('form').submit();
    }

    function copyResult() {
        document.getElementById('result').select();
        document.execCommand('copy');
    }
</script>
