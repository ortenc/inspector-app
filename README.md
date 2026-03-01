# Inspector App

A REST API built with **Symfony** and **API Platform** for managing inspectors and job assignments.

## What it does

- **Inspectors** — CRUD operations for managing inspectors (name, location)
- **Jobs** — CRUD operations for managing jobs (description, status, timestamps)
- **Assessments** — Assign jobs to inspectors, start them, and mark them as complete

### Custom Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/inspectors/{id}/job` | Assign a job to an inspector |
| `PUT` | `/api/inspectors/{id}/job/start/{jobId}` | Start an assigned job |
| `PUT` | `/api/inspectors/{id}/job/complete/{jobId}` | Complete an assigned job |

## Tech Stack

- **PHP / Symfony** — Backend framework
- **API Platform** — REST API & OpenAPI docs
- **Doctrine ORM** — Database layer
- **MySQL 8.0** — Database
- **Docker** — Containerized setup

## Getting Started

```bash
# Start the containers
make up-fresh

# Run migrations
make migrate

# Load sample data
make fixtures

# Open API docs
# http://localhost:8080/api/docs
```
