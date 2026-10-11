# 🐴❤️🐴 Neigh

**Tinder for horses.** Owners sign up, create profiles for their horses and browse other horses. An owner can like another horse on behalf of one of their own horses. When two horses like each other, it's a match, and both owners see each other's email on their Matches page. Admins manage the list of breeds and can remove horse profiles.

University project, built with Laravel 13 on the educational Laravel starter pack. The full app description is in [docs/app-description.md](docs/app-description.md).

## Installation

Requirements: PHP 8.4 and Composer. No Node or `npm` needed: Tailwind CSS and Alpine.js are loaded from a CDN.

```bash
git clone https://github.com/adrianpfeiffer/horsetinder.git
cd horsetinder
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
```

- The app uses SQLite. `migrate:fresh` creates `database/database.sqlite` if it doesn't exist.
- `storage:link` makes uploaded horse photos visible in the browser. The seeded horses have no photos.
- Serve it with Laravel Herd, or run `php artisan serve` and open http://localhost:8000.

## Logging in

| Who | Email | Password |
|---|---|---|
| Admin | `admin@admin.com` | `password` |
| Owners | random emails, see **Admin → Manage horses** | `password` |

The seeder creates the admin, 8 breeds, 10 owners with 1–3 horses each, and random likes, including some mutual ones so there are matches to show.

## What you can do

| Who | Page | Route |
|---|---|---|
| Everyone | Landing page | `/` |
| | Browse horses, horse profile | `/horses`, `/horses/{horse}` |
| | Breeds, breed with its horses | `/breeds`, `/breeds/{breed}` |
| | About | `/about` |
| Owners | My horses: list, add, edit (incl. hide/show and photo), delete | `/my/horses/...` |
| | Like a horse as one of my horses, undo a like | `POST /horses/{horse}/likes`, `DELETE /likes/{like}` |
| | Matches with the other owner's email | `/matches` |
| Admins | Dashboard with counts | `/admin` |
| | Breeds: full CRUD (all 7 methods) | `/admin/breeds/...` |
| | All horses, also hidden ones, and removing them | `/admin/horses` |

## Data model

- **User** hasMany **Horse** (`user_id`)
- **Breed** hasMany **Horse** (`breed_id`)
- **Horse** hasMany given **Like**s (`horse_id`) and received **Like**s (`target_horse_id`)
- A match is not a model: it's two likes in opposite directions, found with the `Like::matched()` scope.

## Tests

```bash
php artisan test
```
