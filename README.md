请在皮肤站的 `.env` 配置文件中添加并填写以下条目：

```bash
MSGRAPH_CLIENT_ID=
MSGRAPH_SECRET_ID=
MSGRAPH_TENANT_ID=
MSGRAPH_TENANT_AUTHORIZE="https://login.microsoftonline.com/${MSGRAPH_TENANT_ID}/adminconsent"
MSGRAPH_TENANT_TOKEN="https://login.microsoftonline.com/${MSGRAPH_TENANT_ID}/oauth2/v2.0/token"

MSGRAPH_MAIL_SENDER=support@littlesk.in
MSGRAPH_MAIL_DEBUG=true
```

权限要求：授予 `User.Read.All` 和 `Mail.Send` 权限，类型为 Application Permission。

设置 Mail Driver：

```bash
MAIL_MAILER=msgraph
```

其中 `MSGRAPH_SECRET_ID` 为 client secret。`MSGRAPH_MAIL_SENDER` 为邮件发送者的用户 UUID（即要从哪个用户发送邮件），也可以填 `userPrincipalName`（一般来说是其主要邮箱地址）。

在本插件目录下运行 `composer install` 安装插件自身的依赖，并在皮肤站根目录下运行数据库迁移：

```bash
php artisan migrate --path=plugins/ms-graph-sendmail/migrations
```
