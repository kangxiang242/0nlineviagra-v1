# 0nlineviagra v1 — 项目根文档

> 威而鋼 Viagra 台灣線上訂購網站。v1 新版（Laravel 12 + Filament 3）。

---

## 快速导航

| 入口 | 地址 |
|------|------|
| 🌐 前台（本地） | http://localhost:8201 |
| 🔐 后台（本地） | http://localhost:8201/admin |
| 👤 后台账号 | `web0wer16888` |
| 🔑 后台密码 | `888d00rkeeper888` |

---

## 技术栈

| 组件 | 版本 |
|:-----|:-----|
| 框架 | Laravel 12.x |
| PHP | ^8.2 |
| 後台 | Filament 3.x |
| 数据库 | MySQL（`0nlineviagra_v1`, root/root2312） |
| 前端构建 | Vite |
| 编辑器 | wangEditor5 |

---

## 项目目录

| 路径 | 说明 |
|------|------|
| `/Users/a123/workspace/wwwroot/新站点/0nlineviagra-v1` | 项目根目录 |
| `storage/app/public/` | 上传文件（从旧站 rsync） |

---

## 源服务器信息（旧版 0nlineviagra.com）

| 项目 | 内容 |
|------|------|
| 域名 | www.0nlineviagra.com |
| IP 地址 | 103.155.93.157 |
| SSH 端口 | 20203 |
| Root 密码 | OWM4i34X |
| 操作系统 | (cloud kernel) 5.2.0 |
| 环境 | Laravel 10 + PHP 8.2 + MySQL 5.7 + Nginx |
| 数据库名 | `0nlineviagra` |
| 数据库账号 | root / yRIzPrhl |
| 站点目录 | `/data/wwwroot/0nlineviagra.com` |
| 服务商 | shinjiru.com |
| Git 旧仓库 | `kangxiang242/0nlineviagra` |

---

## 本地启动

```bash
cd /Users/a123/workspace/wwwroot/新站点/0nlineviagra-v1
php artisan serve --port=8201
```

---

## 数据来源

| 数据 | 来源 | 日期 |
|------|------|------|
| 数据库 | 从 103.155.93.157 导出 `0nlineviagra` → 导入 `0nlineviagra_v1` | 2026-07-13 |
| 上传文件 | rsync 从 103.155.93.157 `storage/app/public/` | 2026-07-13 |
| 模板 | 基于 cialis-store.com-v1 模板构建 | 2026-07-13 |

---

## 已修复问题

| 日期 | 问题 | 修复 |
|:-----|:-----|:-----|
| 2026-07-13 | 控制台 `/storage/` 404 | favicon/logo 模板加 `->value()` 判断 |
| 2026-07-13 | 首页图片 src 为空 | 导入旧站数据库 + rsync 图片文件 |
