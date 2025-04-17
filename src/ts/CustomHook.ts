/* 
    Пример кастомного хука.

    Простенькое изменение searchParams в URL в Next.js Client Component 
    с использованием транзишина для показа полосы загрузки.
*/

"use client";

import { usePathname, useSearchParams, useRouter } from "next/navigation";
import { startTransition } from "react";
import { useProgress } from "react-transition-progress";

export default function useParamsChanger(): (
    paramName: string,
    value: string
) => void {
    const path = usePathname();
    const searchParams = useSearchParams();
    const router = useRouter();
    const startProgress = useProgress();

    function changeSearchParams(paramName: string, value: string): void {
        startTransition(() => {
            startProgress();
            const newSearchParams = new URLSearchParams(searchParams);
            newSearchParams.set(paramName, value);
            const newPath = `${path}?${newSearchParams.toString()}`;
            router.push(newPath);
        });
    }

    return changeSearchParams;
}
