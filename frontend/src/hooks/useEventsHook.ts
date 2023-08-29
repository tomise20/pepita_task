import axios from "axios";
import { EventSourceInput } from "@fullcalendar/core/index.js";

import { useQuery } from "react-query";

type ServerResponse<ResponseBody> = {
  body: ResponseBody;
  isSuccess: boolean;
};

export function useEventsHook(selectedMonth?: string) {
  console.log("selected: ", selectedMonth);
  return useQuery<EventSourceInput>({
    queryKey: ["events"],
    queryFn: async () => {
      const resp = await axios.get<ServerResponse<EventSourceInput>>(
        "http://localhost/api/reservations",
        {
          params: {
            date: selectedMonth ?? null,
          },
        }
      );

      if (resp.data.isSuccess) {
        return resp.data.body;
      }

      throw new Error("Hiba történt!");
    },
  });
}
