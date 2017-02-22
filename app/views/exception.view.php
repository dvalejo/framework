<style>
    .error {
        font-size: 16px;
        font-family: "Georgia", sans-serif;
        border: 2px solid #eeeeee;
    }
    .error__header {
        padding: 20px;
        font-size: 20px;
        line-height: 1;
        background-color: #eeeeee;
    }
    .error__details {
        margin: 0 0 15px 0;
        color: #000;
    }
    .error__type {
        color: #000000;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.25);
    }
    .error__place {
        color: #939393;
    }
    .error__message {
        font-size: 20px;
        line-height: 1;
        color: #000000;
    }
    .error__trace {
        padding: 20px;
        line-height: 1.5;
        background: #ffffff;
        color: rgba(0, 0, 0, 1);
    }
    .error__trace-item {
      margin: 0 0 5px 0;
    }
</style>
<div class="error">
    <div class="error__header">
        <div class="error__details">
            <span class="error__type" title="<?= $this->getHeader(true) ?>"><?= $this->getHeader(true) ?></span>&nbsp;in
            <span class="error__place"><?= $this->getFilename() ?>&nbsp;(line&nbsp;<?= $this->getLine() ?>):</span>
        </div>
        <div class="error__message">« <?= $this->getMessage() ?> »</div>
    </div>
    <div class="error__trace">
      <?php foreach ($this->traces() as $trace): ?>
      <div class="error__trace-item">
          <?= $trace ?>
      </div>
      <?php endforeach; ?>
    </div>
</div>