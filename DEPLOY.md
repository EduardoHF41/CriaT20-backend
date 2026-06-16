# Deploy gratuito — CriaT20

Stack: **Vercel** (frontend Angular) · **Render** (backend Laravel/Docker) · **Neon** (PostgreSQL).

A ordem importa por causa das URLs que um serviço precisa do outro:
**1) Neon → 2) Render → 3) Vercel → 4) ligar CORS de volta no Render.**

---

## 1. Banco de dados — Neon (PostgreSQL)

1. Crie conta em https://neon.tech (login com GitHub, sem cartão).
2. **Create project** → nome `criat20` → escolha uma região (anote, use a mesma no Render).
3. No **Dashboard → Connection string**, copie a string no formato:
   ```
   postgresql://USUARIO:SENHA@ep-xxxx.REGIAO.aws.neon.tech/neondb?sslmode=require
   ```
   Guarde — é o valor de `DB_URL` no Render.

---

## 2. Backend — Render (Docker)

1. Crie conta em https://render.com (login com GitHub).
2. **New → Blueprint** → conecte o repo `EduardoHF41/CriaT20-backend`.
   O Render lê o [`render.yaml`](render.yaml) e cria o web service `criat20-backend`.
   (Se preferir manual: **New → Web Service** → repo → Runtime **Docker** → Dockerfile path `./Dockerfile.prod` → plano **Free**.)
3. Em **Environment**, preencha as variáveis marcadas como `sync: false`:

   | Variável        | Valor |
   |-----------------|-------|
   | `APP_KEY`       | `base64:Apa1nhDCt/cyFv1XXD6IC3l3xl9PiGu4FRXc3zXsQzA=` |
   | `APP_URL`       | `https://criat20-backend.onrender.com` |
   | `DB_URL`        | (connection string do Neon, com `?sslmode=require`) |
   | `FRONTEND_URL`  | deixe vazio por enquanto — preenche no passo 4 |

> Região: o `render.yaml` usa **virginia** (o free não tem São Paulo), que é a mais
> próxima do Neon em `sa-east-1`. Haverá alguma latência banco↔backend — inevitável no free.

4. **Create / Deploy.** O primeiro build leva alguns minutos. Quando ficar **Live**, teste:
   ```
   https://criat20-backend.onrender.com/up   → deve responder "ok" (health check)
   ```
   As migrations rodam sozinhas no boot (entrypoint).

> ⚠️ Plano free **dorme após 15 min** sem uso; o primeiro acesso depois disso leva ~50s. Normal.

---

## 3. Frontend — Vercel (Angular)

1. Crie conta em https://vercel.com (login com GitHub).
2. **Add New → Project** → importe `EduardoHF41/CriaT20-Frontend`.
3. **Root Directory:** clique em *Edit* e selecione **`src`** (onde está o `package.json`).
   O resto a Vercel detecta pelo [`vercel.json`](../CriaT20-Frontend/src/vercel.json):
   - Build: `npm run build`
   - Output: `dist/src/browser`
4. **Deploy.** Anote a URL final, ex: `https://criat20.vercel.app`.

> Se o backend estiver em outra URL que não `criat20-backend.onrender.com`, ajuste o
> `apiUrl` em [`environment.prod.ts`](../CriaT20-Frontend/src/src/environments/environment.prod.ts) e refaça o deploy.

---

## 4. Ligar o CORS de volta (importante!)

Sem isso o navegador bloqueia as chamadas do front pro back.

1. No **Render → criat20-backend → Environment**, defina:
   ```
   FRONTEND_URL = https://criat20.vercel.app   (a URL real da Vercel)
   ```
2. **Save** → o Render redeploy automático.

Os previews da Vercel (`*.vercel.app`) já são liberados pelo padrão em [`config/cors.php`](src/config/cors.php).

---

## Checklist final

- [ ] `GET /up` no backend responde ok
- [ ] Login/registro funciona no site da Vercel
- [ ] Criar personagem e listar funciona (backend + Neon)
- [ ] Upload de avatar funciona (Cloudinary)
- [ ] Nenhum erro de CORS no console do navegador

## Variáveis de ambiente do backend (referência)

Já definidas no `render.yaml` com valor fixo: `APP_NAME`, `APP_ENV=production`,
`APP_DEBUG=false`, `LOG_CHANNEL=stderr`, `DB_CONNECTION=pgsql`, `DB_SSLMODE=require`,
`SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=sync`,
`FILESYSTEM_DISK=local`.
