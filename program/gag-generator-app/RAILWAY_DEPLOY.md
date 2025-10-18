# Railway デプロイ設定

## 必須環境変数

Railwayのダッシュボード > Variables タブで以下の環境変数を設定してください：

```bash
APP_NAME=gag-generator-app
APP_ENV=production
APP_KEY=base64:nReS1LuH5lsEl2UKE5g2ecZk+ZnsEp+ricdcA9M+mQM=
APP_DEBUG=false
APP_URL=https://${RAILWAY_PUBLIC_DOMAIN}
ASSET_URL=https://${RAILWAY_PUBLIC_DOMAIN}
DB_CONNECTION=sqlite
LOG_CHANNEL=stack
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## 注意事項

- `APP_URL` と `ASSET_URL` は `https://${RAILWAY_PUBLIC_DOMAIN}` という変数を使用
- Railwayが自動的にドメインに置き換えます
- デプロイ後、ブラウザのキャッシュをクリア (Cmd+Shift+R / Ctrl+Shift+R)

## トラブルシューティング

CSSが表示されない場合：
1. Railway のログでビルドエラーがないか確認
2. `public/build/manifest.json` が生成されているか確認
3. ブラウザの開発者ツールでネットワークタブを確認し、CSSファイルが404になっていないか確認
