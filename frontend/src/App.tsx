import FullCalendar from "@fullcalendar/react";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridWeek from "@fullcalendar/timegrid";

import { DateSelectArg, DatesSetArg } from "@fullcalendar/core/index.js";
import { useEventsHook } from "./hooks/useEventsHook";
import "./App.css";
import axios from "axios";
import { formattedDate } from "./utils/helpers";
import { useQueryClient } from "react-query";
import { useState } from "react";

function App() {
  const queryClient = useQueryClient();
  const [selectedDate, setSelectedDate] = useState<string>();

  function handleSelect(args: DateSelectArg): void {
    const name = prompt("Kérjük add meg a neved");
    const startDate = formattedDate(args.start);
    const endDate = formattedDate(args.end);
    const date = new Date();

    axios
      .post("http://localhost/api/reservations", {
        name,
        startDate,
        endDate: endDate,
        startTime: date.getHours() + ":00",
        endTime: date.getHours() + 1 + ":00",
        repeate: "NEVER",
      })
      .then(() => {
        alert("Esemény sikeresen létrhozva!");
        queryClient.invalidateQueries(["events"]);
      });
  }

  const eventsQuery = useEventsHook(selectedDate);

  function handleChangeMonth(event: DatesSetArg): void {
    const midDate = new Date((event.start.getTime() + event.end.getTime()) / 2);

    const date = formattedDate(midDate);
    setSelectedDate(date);
  }

  if (eventsQuery.isLoading) {
    return (
      <div className="text-center">Események betöltése folyamatban...</div>
    );
  }

  if (!eventsQuery.isSuccess) {
    return (
      <div className="text-center text-red-500">
        Hiba történt kérjük próbáld újra...
      </div>
    );
  }

  return (
    <div className="container max-w-[1400px] mx-auto">
      <FullCalendar
        plugins={[dayGridPlugin, interactionPlugin, timeGridWeek]}
        initialView="dayGridMonth"
        headerToolbar={{
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay",
        }}
        selectable={true}
        selectMirror={true}
        dayMaxEvents={true}
        select={handleSelect}
        initialEvents={eventsQuery.data!}
        expandRows={true}
        datesSet={handleChangeMonth}
      />
    </div>
  );
}

export default App;
