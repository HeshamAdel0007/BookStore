const Inputs = ({
  LabelName = 'E-Mail',
  InputClass = 'inputclass',
  Id = 'email',
  Type = 'text',
  Placeholder = 'your E-Mail',
  InputValue = 'hesham@adel.com',
  ...props
}) => {
  return (
    <>
      <label>{LabelName} </label>
      <input
        className={InputClass + ' text-black'}
        id={Id}
        type={Type}
        placeholder={Placeholder}
        value={InputValue}
      />
    </>
  )
}
export default Inputs
