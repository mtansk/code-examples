/* 

    Пример главного контекста для доступа к состоянию авторизации в приложении.
    (Конечно же, только для отображения на клиенте. За саму авторизацию отвечает серверная часть приложения.)

*/

"use client";

import {
    AuthorizationPayload,
    ClientAccessState,
} from "@/app/types/access/Access";
import { createContext, useMemo, useState } from "react";

type ClientAccessStateContextType = {
    state: ClientAccessState;
    setter: React.Dispatch<React.SetStateAction<ClientAccessState>>;
};

const defStateObj = {
    accessLevel: "guest",
    accessState: "none",
    accountId: "",
    companyId: "",
    userId: "",
};

// создание контекста
export const ClientAccessStateContext =
    createContext<ClientAccessStateContextType>({
        state: defStateObj,
        setter: () => {},
    });

// создание провайдера
export default function ClientAccessStateProvider({
    children,
}: {
    children: React.ReactNode;
}) {
    const [clientAccessState, setClientAccessState] =
        useState<ClientAccessState>(defStateObj);

    const value = useMemo(
        () => ({ state: clientAccessState, setter: setClientAccessState }),
        [clientAccessState]
    );

    return (
        <ClientAccessStateContext value={value}>
            {children}
        </ClientAccessStateContext>
    );
}

// функция для быстрого установления контекста из ответа API с данными об авторизации
export function changeAccessContextWithAuthPayload(
    payload: AuthorizationPayload,
    setter: React.Dispatch<React.SetStateAction<ClientAccessState>>
): void {
    setter({
        accessLevel: payload.access_level,
        accessState: payload.access_state,
        accountId: payload.account_id,
        companyId: payload.company_id,
        userId: payload.user_id,
    });
}
