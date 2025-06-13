-- Consulta para obtener las tareas pendientes de un usuario específico, ordenadas de la más reciente a la más antigua.
SELECT id, user_id, title, completed, created_at
FROM tasks
WHERE user_id = ? AND completed = 0
ORDER BY created_at DESC;

-- Explicación: Esta consulta trae solo las tareas que aún no han sido completadas (completed = 0)
-- de un usuario en particular, y las ordena por fecha de creación para traer la mas nueva

-- Índice sugerido: Para que esta consulta sea más rápida, especialmente si hay muchas tareas,
-- se puede crear un índice compuesto:
CREATE INDEX idx_user_completed_created ON tasks(user_id, completed, created_at DESC);

-- Con este indice se incluye las columnas por las que filtramos y ordenamos, la bd puede encontrar
-- los datos más rápido sin mirar toda la tabla
