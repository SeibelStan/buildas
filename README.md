# Buildas

```cfg.json``` - настройки сборщика:
    
    source - файлы на вход
    output - файлы на выход
    min - флаг для минификации
    builded - метка последней сборки

```builder.php``` - склеивает и отправляет на минификацию ассеты из ```cfg.json```. Можно установить CRON-задачу.

```lib.php``` - вспомогательные функции.

----

Пересборка производится только при изменении исходников или конфига. Протестировано на jQuery и сложных скриптах.

Для использования в своём проекте, отредактируйте пути ```BUILDAS_DIR``` и ```BUILDAS_ASDIR``` в ```lib.php```.

Можно использовать с внешними файлами. Не рекомендуется использовать минификацию для уже минифицированных файлов.

Совместимо с [MdlCMS](https://github.com/SeibelStan/mdlcms).