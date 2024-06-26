import React from "react";

function ProgramCard({ presensi, program }) {
    const iconProgram = {
        "Angkat Beban": "/assets/img/exercise-weight.png",
        Yoga: "/assets/img/exercise-yoga.png",
        Zumba: "/assets/img/exercise-zumba.png",
        Boxing: "/assets/img/exercise-boxing.png",
    };

    return (
        <div
            className={`box-border flex w-full items-center gap-2 rounded-lg p-4 outline-dashed outline-2 ${presensi ? "outline-green-500" : "outline-lime-500"} md:w-[calc(50%-1.25rem)] lg:w-[calc(33.333%-1.25rem)] ${presensi ? " opacity-50" : null}`}
        >
            <div className="flex h-full w-16 items-center justify-center rounded-md bg-slate-800">
                <img src={iconProgram[program]} alt={program} />
            </div>
            <div className="ml-2">
                <h5 className="text-xl font-bold text-slate-100">{program}</h5>
                <p>Tanpa personal trainer</p>
                {presensi ? (
                    <p className="text-sm text-red-500">
                        Anda sudah melakukan presensi hari ini
                    </p>
                ) : (
                    <p className="text-sm text-lime-500">
                        Anda belum melakukan presensi hari ini
                    </p>
                )}
            </div>
        </div>
    );
}

ProgramCard.defaultProps = {
    presensi: false,
    program: "Angkat Beban",
};

export default ProgramCard;
