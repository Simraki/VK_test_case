<?php


class Utils {
    public static function getRandomInt(int $min, int $max): int {
        try {
            return random_int($min, $max);
        } catch(Exception $e) {
            // TODO: uses die()
            Main::sendError(__CLASS__, __FUNCTION__);
            die;
        }
    }

    public static function error(array $error, string $filename = null, string $method = null): void {
        $filename = $filename ?? debug_backtrace()[1]['class'] ?? 'Unknown';
        $method = $method ?? debug_backtrace()[1]['function'] ?? 'Unknown';

        JSON_RPC::sendErrorResponse($error, $filename, $method);
    }

    public static function bfs(array $graph, int $start_node, int $end_node): bool {
        $queue = new SplQueue();
        $queue->enqueue($start_node);
        $visited = [$start_node];

        while (!$queue->isEmpty()) {
            $node = $queue->dequeue();

            if ($node === $end_node) {
                return true;
            }
            if ($graph[$node] === null) {
                continue;
            }

            foreach ($graph[$node] as $neighbour) {
                if (!in_array($neighbour, $visited, true)) {
                    $visited[] = $neighbour;
                    $queue->enqueue($neighbour);
                }
            }
        }

        return false;
    }
}