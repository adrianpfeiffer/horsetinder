# Part A – App Idea: Neigh

Submitted Oct 6, 2026 · @Adrian

## Description

Neigh is Tinder for horses. Owners sign up, create profiles for their horses and browse other horses. A logged-in owner can like another horse on behalf of one of their own horses. When two horses like each other, it's a match, and both owners see each other's email on their Matches page. Admins manage the list of breeds and can remove horse profiles.

## Models and properties

| Model | Properties |
|-------|------------|
| User  | name, email, password, role (`user` / `admin`) |
| Breed | name, origin_country, description |
| Horse | user_id, breed_id, name, gender (`mare` / `stallion` / `gelding`), birth_date, discipline (`dressage` / `jumping` / `leisure`), city, bio, photo_path, is_active (`false` = hidden from browsing) |
| Like  | horse_id (the horse that likes), target_horse_id (the horse that is liked) |

All models also have `id` and timestamps. A horse can like another horse only once, and never itself.

Each model has a factory. The seeder creates an admin, 10 owners with 1–3 horses each, and 8 breeds. It then adds random likes, including some mutual ones, so there are matches to show.

## Relations

**User–Horse** is a 1-N relationship
- A `User` hasMany horses
- A `Horse` belongsTo an owner (user)

**Breed–Horse** is a 1-N relationship
- A `Breed` hasMany horses
- A `Horse` belongsTo a breed

**Horse–Like** is a 1-N relationship, twice: once for the horse giving the like, once for the horse receiving it
- A `Horse` hasMany givenLikes (via `horse_id`) and hasMany receivedLikes (via `target_horse_id`)
- A `Like` belongsTo a horse (the liker) and belongsTo a targetHorse (the liked horse)

A match is not a model. It is two likes in opposite directions (A likes B and B likes A), found with a query on the likes table.

## ER diagram

Horse is the centre: one owner, one breed, many likes.

```
┌──────────────┐ 1      N ┌────────────────────┐ N      1 ┌────────────────┐
│ User         │──────────│ Horse              │──────────│ Breed          │
│ name, email, │          │ user_id, breed_id, │          │ name,          │
│ role         │          │ name, gender, city │          │ origin_country │
└──────────────┘          └────────────────────┘          └────────────────┘
                              1 │        │ 1
                          gives │        │ receives
                              N │        │ N
                          ┌────────────────────┐
                          │ Like               │
                          │ horse_id,          │
                          │ target_horse_id    │
                          └────────────────────┘
               A match = two horses that liked each other
```

## Routes

```
// public
GET    /                          home                  -> landing page
GET    /horses                    horses.index          -> browse horses
GET    /horses/{horse}            horses.show           -> profile + like
GET    /breeds                    breeds.index          -> list of breeds
GET    /breeds/{breed}            breeds.show           -> breed + horses
GET    /about                     about                 -> about page

// login, register, logout (Laravel auth scaffolding)

// logged in: my horses CRUD
GET    /my/horses                 my.horses.index       -> list of my horses
GET    /my/horses/create          my.horses.create      -> empty form
POST   /my/horses                 my.horses.store       -> save new horse
GET    /my/horses/{horse}/edit    my.horses.edit        -> edit form
PUT    /my/horses/{horse}         my.horses.update      -> save changes
DELETE /my/horses/{horse}         my.horses.destroy     -> delete horse

// logged in: likes and matches
POST   /horses/{horse}/likes      likes.store           -> like as my horse
DELETE /likes/{like}              likes.destroy         -> undo a like
GET    /matches                   matches.index         -> matches + emails

// admin
GET    /admin                     admin.dashboard       -> overview
                                  admin.breeds.*        -> breed CRUD
GET    /admin/horses              admin.horses.index    -> all horses
DELETE /admin/horses/{horse}      admin.horses.destroy  -> remove a horse
```
